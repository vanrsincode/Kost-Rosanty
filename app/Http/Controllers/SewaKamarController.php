<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\SewaKamar;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class SewaKamarController extends Controller
{
    public function dataTableSewaKamar(Request $request)
    {
        if ($request->ajax()) {
            $sewaKamar = SewaKamar::with('kamar', 'penghuni')->orderBy('created_at', 'desc')->get();
            return DataTables::of($sewaKamar)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => $row->penghuni->nama_penghuni)
                ->editColumn('kamar_tipe', fn($row) => $row->kamar->nomor_kamar . '/' . $row->kamar->tipe_kamar)
                ->editColumn('harga', fn($row) => 'Rp. ' . number_format($row->kamar->harga_kamar, 0, '.', ','))
                ->editColumn('tgl_sewa', fn($row) => Carbon::createFromFormat('Y-m-d', $row->tgl_awal_sewa)->isoFormat('DD MMM Y'))
                ->editColumn('no_wa', fn($row) => $row->penghuni->telepon_penghuni)
                ->addColumn('action', function ($row) {
                    $btn = '<button data-id="' . $row->id . '"  class="btn btn-warning btn-sm width-btn text-white editData" title="Edit Data"><i class="far fa-edit"></i></button> ';
                    $btn .= '<button data-id="' . $row->id . '" data-nama="' . $row->penghuni->nama_penghuni . '" class="btn btn-danger btn-sm width-btn text-white deleteData" title="Hapus Data"><i class="far fa-trash-alt"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.penyewaan-kos.penyewa-kamar.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'          => 'required',
                'nik'           => 'required|min:16|max:16|unique:penghuni,nik_penghuni',
                'tempat_lahir'  => 'required',
                'tgl_lahir'     => 'required',
                'email'         => 'required|unique:users,email',
                'no_wa'         => 'required|unique:penghuni,telepon_penghuni',
                'alamat'        => 'required',
                'selkamar'      => 'required'
            ],
            [
                'nama.required'             => 'Nama harus diisi.',
                'nik.required'              => 'NIK harus diisi.',
                'nik.min'                   => 'NIK harus min 16 karakter!',
                'nik.max'                   => 'NIK tidak boleh melebihi 16 karakter!',
                'nik.unique'                => 'NIK sudah ada atau sudah terpakai.',
                'tempat_lahir.required'     => 'Tempat Lahir harus diisi.',
                'tgl_lahir.required'        => 'Tanggal Lahir harus diisi.',
                'email.required'            => 'Email harus diisi.',
                'email.unique'              => 'Email sudah ada atau sudah terpakai.',
                'no_wa.required'            => 'No. WhatsApp harus diisi.',
                'no_wa.unique'              => 'No. WhatsApp sudah ada atau sudah terpakai.',
                'alamat.required'           => 'Alamat harus diisi.',
                'selkamar.required'         => 'Kamar harus diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors'    => $validator->errors()]);
        }

        $today = Carbon::now()->toDateString();
        $password = 'KostRosanty00';

        // WA
        $baseUrl = url('/');
        $message = "Hai " . $request->nama . ",\n\n" .
            "Selamat datang di Kost Putri Rosanty! Berikut adalah informasi login untuk akses ke sistem website kami: \n\n" .
            "Email : " . $request->email . "\n" .
            "Password : " . $password . "\n\n" .
            "Silakan gunakan informasi di atas untuk login di " . $baseUrl . ". Kami menyarankan Anda untuk segera mengubah password setelah masuk ke akun Anda untuk keamanan yang lebih baik. Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami dengan balas pesan ini. \n\n" .
            "Salam hangat, \nAdmin Kost Putri Rosanty";
        $this->sendWA($request->no_wa, $message);
        //

        $user = User::create([
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($password),
            'role'      => 2,
            'text'      => $password
        ]);

        $penghuni = Penghuni::create([
            'nama_penghuni'     => $request->nama,
            'nik_penghuni'      => $request->nik,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tgl_lahir,
            'telepon_penghuni'  => $request->no_wa,
            'alamat_penghuni'   => $request->alamat,
            'user_id'           => $user->id
        ]);

        $sewa = SewaKamar::create([
            'tgl_awal_sewa'     => $today,
            'kamar_id'          => $request->selkamar,
            'penghuni_id'       => $penghuni->id
        ]);

        $tglAwalSewa  = Carbon::parse($sewa->tgl_awal_sewa);

        $orderID = Uuid::uuid4()->toString();

        $this->configMidtrans();

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderID,
                'gross_amount' => $sewa->kamar->harga_kamar,
            ),
            'item_details' => array(
                array(
                    'id'    => $sewa->kamar->id,
                    'price' => $sewa->kamar->harga_kamar,
                    'quantity' => 1,
                    'name'  => 'Kamar : ' . $sewa->kamar->nomor_kamar . '/' . $sewa->kamar->tipe_kamar,
                )
            ),
            'customer_details' => array(
                'first_name' => $sewa->penghuni->nama_penghuni,
                'email' => $sewa->penghuni->user->email,
            ),
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s T", time()),
                'unit' => 'days',
                'duration' => 90
            ],
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        Transaksi::create([
            'order_id'      => $orderID,
            'bulan_tagihan' => $tglAwalSewa->month,
            'tahun_tagihan' => $tglAwalSewa->year,
            'total_bayar'   => $sewa->kamar->harga_kamar,
            'snap_token' => $snapToken,
            'penghuni_id' => $penghuni->id
        ]);

        Kamar::findOrFail($request->selkamar)->update(['status_kamar' => 'Terpakai']);

        return response()->json([
            'success'   => true,
            'snap_token' => $snapToken,
        ], 200);
    }

    public function show(Request $request, string $id)
    {
        if ($request->ajax()) {
            $sewaKamar = SewaKamar::with(
                'kamar:id,nomor_kamar,tipe_kamar,harga_kamar as harga,ket_kamar,status_kamar',
                'penghuni:id,nama_penghuni as nama,nik_penghuni as nik,tempat_lahir,tanggal_lahir as tgl_lahir,telepon_penghuni as no_wa,alamat_penghuni as alamat,user_id',
                'penghuni.user:id,email'
            )->findOrFail($id);
            return response()->json([
                'data'      => $sewaKamar
            ], 200);
        }
    }

    public function update(Request $request, string $id)
    {
        $sewaKamar = SewaKamar::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required|min:16|unique:penghuni,nik_penghuni,' . $sewaKamar->penghuni->id,
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'email' => 'required|unique:users,email,' . $sewaKamar->penghuni->user_id,
            'no_wa' => 'required|unique:penghuni,telepon_penghuni,' . $sewaKamar->penghuni->id,
            'alamat' => 'required',
            'selkamar' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'nik.min' => 'NIK harus 16 karakter!',
            'nik.unique' => 'NIK sudah ada atau sudah terpakai.',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi.',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah ada atau sudah terpakai.',
            'no_wa.required' => 'No. WhatsApp harus diisi.',
            'no_wa.unique' => 'No. WhatsApp sudah ada atau sudah terpakai.',
            'alamat.required' => 'Alamat harus diisi.',
            'selkamar.required' => 'Kamar harus diisi.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Perbarui kamar jika ada perubahan
        if ($sewaKamar->kamar_id != $request->selkamar) {
            $sewaKamar->kamar->update(['status_kamar' => 'Tersedia']);
            Kamar::findOrFail($request->selkamar)->update(['status_kamar' => 'Terpakai']);
        }

        // Perbarui sewa kamar
        $sewaKamar->update(['kamar_id' => $request->selkamar]);

        // Perbarui data penghuni
        $penghuni = $sewaKamar->penghuni;
        $penghuni->update([
            'nama_penghuni' => $request->nama,
            'nik_penghuni' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tgl_lahir,
            'telepon_penghuni' => $request->no_wa,
            'alamat_penghuni' => $request->alamat,
        ]);

        // Perbarui data pengguna
        $penghuni->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        return response()->json(['success' => true], 200);
    }


    public function destroy(Request $request, string $id)
    {
        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah.']);
        }

        $sewaKamar = SewaKamar::findOrFail($id);
        if ($sewaKamar) {
            $sewaKamar->kamar->update(['status_kamar' => 'Tersedia']);

            $sewaKamar->delete();
            $sewaKamar->penghuni->user->delete();
            $sewaKamar->penghuni->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    private function sendWA($noWA, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $noWA,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . env('WA_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error('Fonnte WhatsApp error: ' . $error_msg);
        }
        curl_close($curl);

        if (isset($response)) {
            Log::info('Pesan WhatsApp berhasil dikirim: ' . $response);
        }
    }

    private function configMidtrans()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
}
