<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\SewaKamar;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class TagihanController extends Controller
{
    public function dataTableTagihan(Request $request)
    {
        if ($request->ajax()) {
            $tagihan = Transaksi::with('penghuni', 'penghuni.sewaKamar', 'penghuni.sewaKamar.kamar')
                ->where('status_transaksi', '!=', 'Lunas')
                ->orderBy('tahun_tagihan', 'desc')
                ->orderBy('bulan_tagihan', 'desc')->get();
            return DataTables::of($tagihan)
                ->addIndexColumn()
                ->addColumn('nama', fn($row) => $row->penghuni->nama_penghuni)
                ->addColumn('kamar', fn($row) => "{$row->penghuni->sewaKamar->kamar->nomor_kamar}/{$row->penghuni->sewaKamar->kamar->tipe_kamar}")
                ->addColumn('tarif', fn($row) => 'Rp. ' . number_format($row->total_bayar, 0, ',', '.'))
                ->addColumn(
                    'bulan_tahun',
                    fn($row) =>
                    Carbon::createFromFormat('m', $row->bulan_tagihan)->translatedFormat('F') . ' ' .
                        Carbon::createFromFormat('Y', $row->tahun_tagihan)->format('Y')
                )
                ->addColumn(
                    'action',
                    fn($row) =>
                    '<button type="button" data-id="' . $row->id . '" data-nama="' . $row->penghuni->nama_penghuni . '" class="btn btn-success btn-sm width-btn text-white payCash" title="Bayar Tunai"><i class="far fa-money-bill-alt"></i></button> ' .
                        '<button type="button" data-id="' . $row->id . '" data-nama="' . $row->penghuni->nama_penghuni . '" class="btn btn-danger btn-sm width-btn text-white deleteData" title="Hapus Data"><i class="far fa-trash-alt"></i></button>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.transaksi.tagihan.index');
    }

    public function getPenghuniBelumAda(Request $request)
    {
        $bulan = $request->bulan;
        [$tahun, $bulanAngka] = explode('-', $bulan);

        // Cari penghuni yang terdaftar di bulan ini atau sebelumnya dan belum memiliki tagihan
        $penghuniBelumAda = Penghuni::with('sewaKamar', 'transaksi')
            ->whereHas('sewaKamar', function ($query) use ($tahun, $bulanAngka) {
                // Ambil penghuni yang terdaftar pada bulan yang sama atau sebelumnya
                $query->where(function ($query) use ($tahun, $bulanAngka) {
                    $query->where(function ($query) use ($tahun, $bulanAngka) {
                        // Ambil penghuni yang terdaftar pada bulan yang sama atau sebelumnya di tahun yang sama
                        $query->whereYear('tgl_awal_sewa', '=', $tahun)
                            ->whereMonth('tgl_awal_sewa', '<=', $bulanAngka);
                    })
                        // Ambil penghuni yang terdaftar pada bulan yang lebih awal di tahun sebelumnya
                        ->orWhere(function ($query) use ($tahun, $bulanAngka) {
                            $query->whereYear('tgl_awal_sewa', '<', $tahun);
                        });
                });
            })
            ->whereDoesntHave('transaksi', function ($query) use ($tahun, $bulanAngka) {
                // Cek apakah penghuni sudah memiliki tagihan di bulan tersebut
                $query->where('bulan_tagihan', $bulanAngka)
                    ->where('tahun_tagihan', $tahun);
            })
            ->get()
            ->map(function ($penghuni) {
                return [
                    'id' => $penghuni->id,
                    'nama_penghuni' => $penghuni->nama_penghuni
                ];
            });

        return response()->json(['data' => $penghuniBelumAda]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['bulan' => 'required', 'penghuni_ids' => 'required|array'],
            ['bulan.required' => 'Bulan harus diisi.']
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Carbon::setLocale('id');
        $carbonDate = Carbon::createFromFormat('Y-m', $request->bulan);
        $year = $carbonDate->year;
        $month = $carbonDate->month;
        $monthName = $carbonDate->translatedFormat('F');

        $penghuniIds = $request->penghuni_ids;
        $penghunis = Penghuni::with('sewaKamar', 'user')->whereIn('id', $penghuniIds)->get();

        $createdTransaksi = [];

        foreach ($penghunis as $vpenghuni) {
            try {
                $orderID = Uuid::uuid4()->toString();

                $this->configMidtrans();

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $orderID,
                        'gross_amount' => $vpenghuni->sewaKamar->kamar->harga_kamar,
                    ),
                    'item_details' => array(
                        array(
                            'id'    => $vpenghuni->sewaKamar->kamar->id,
                            'price' => $vpenghuni->sewaKamar->kamar->harga_kamar,
                            'quantity' => 1,
                            'name'  => 'Kamar : ' . $vpenghuni->sewaKamar->kamar->nomor_kamar . '/' . $vpenghuni->sewaKamar->kamar->tipe_kamar,
                        )
                    ),
                    'customer_details' => array(
                        'first_name' => $vpenghuni->nama_penghuni,
                        'email' => $vpenghuni->user->email,
                    ),
                    'expiry' => [
                        'start_time' => date("Y-m-d H:i:s T", time()),
                        'unit' => 'days',
                        'duration' => 90
                    ],
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $newTransaksi = Transaksi::create([
                    'order_id' => $orderID,
                    'bulan_tagihan' => $month,
                    'tahun_tagihan' => $year,
                    'penghuni_id' => $vpenghuni->id,
                    'tgl_pembayaran' => null,
                    'total_bayar' => $vpenghuni->sewaKamar->kamar->harga_kamar,
                    'metode_pembayaran' => null,
                    'status_transaksi' => 'Belum Lunas',
                    'snap_token' => $snapToken,
                ]);
                $createdTransaksi[] = $newTransaksi;

                // WA
                $baseUrl = url('/');
                $message = "Hai " . $vpenghuni->nama_penghuni . ",\n\n" .
                    "Tagihan kost untuk Bulan " . $monthName . " Tahun " . $year . " telah diterbitkan. Berikut rincian tagihan anda:\n\n" .
                    "Jumlah: Rp " . number_format($vpenghuni->sewaKamar->kamar->harga_kamar, 0, ',', '.') . "\n" .
                    "Kamar: " . $vpenghuni->sewaKamar->kamar->nomor_kamar . " (" . $vpenghuni->sewaKamar->kamar->tipe_kamar . ")\n\n" .
                    "Silakan lakukan pembayaran secara online melalui web kami " . $baseUrl . " atau secara tunai melalui admin. Terima kasih.\n\n" .
                    "Salam hangat, \nAdmin Kost Putri Rosanty";
                $this->sendWA($vpenghuni->telepon_penghuni, $message);
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => ['midtrans' => ['Terjadi kesalahan saat memproses pembayaran, coba lagi nanti.']],
                ]);
            }
        }

        return response()->json($createdTransaksi);
    }

    public function bayarTunai(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $today = Carbon::now()->toDateString();

        $transaksi->update([
            'tgl_pembayaran'    => $today,
            'metode_pembayaran' => 'Tunai',
            'status_transaksi'  => 'Lunas'
        ]);

        $penghuni = $transaksi->penghuni;
        $kamar = $transaksi->penghuni->sewaKamar->kamar;
        $month = Carbon::createFromFormat('m', $transaksi->bulan_tagihan)->translatedFormat('F');
        $year = $transaksi->tahun_tagihan;
        $message = "Hai " . $penghuni->nama_penghuni . ",\n\n" .
            "Pembayaran anda Bulan " . $month . " Tahun " . $year . " Kamar " . $kamar->nomor_kamar . " (" . $kamar->tipe_kamar . ") " .
            "sebesar Rp " . number_format($kamar->harga_kamar, 0, ',', '.') . " telah kami terima dengan metode pembayaran Tunai.\n\n" .
            "Status Transaksi: Lunas.\n" .
            "Tanggal Input Pembayaran: " . Carbon::createFromFormat('Y-m-d', $today)->isoFormat('D MMMM Y') . ".\n\n" .
            "Terima kasih telah melakukan pembayaran tepat waktu.\n\n" .
            "Salam hangat, \nAdmin Kost Putri Rosanty";

        $this->sendWA($penghuni->telepon_penghuni, $message);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return response()->json(['success' => true], 200);
    }

    public function handlePaymentNotif(Request $request)
    {
        $payload = $request->all();

        Log::info('incoming-midtrans', [
            'payload'   => $payload
        ]);

        $orderID        = $payload['order_id'];
        $statusCode     = $payload['status_code'];
        $grossAmount    = $payload['gross_amount'];
        $paymentType    = strtoupper($payload['payment_type']);
        $transactionStatus  = $payload['transaction_status'];

        $reqSignature   = $payload['signature_key'];

        $signature      = hash('sha512', $orderID . $statusCode . $grossAmount . config('midtrans.serverKey'));

        if ($signature != $reqSignature) {
            return response()->json([
                'message'   => 'invalid signature'
            ], 401);
        }

        $order  = Transaksi::where('order_id', $orderID)->first();

        $today = Carbon::now()->toDateString();
        $penghuni = $order->penghuni;
        $kamar = $order->penghuni->sewaKamar->kamar;
        $month = Carbon::createFromFormat('m', $order->bulan_tagihan)->translatedFormat('F');
        $year = $order->tahun_tagihan;

        $message = "Hai " . $penghuni->nama_penghuni . ",\n\n" .
            "Pembayaran anda Bulan " . $month . " Tahun " . $year . " Kamar " . $kamar->nomor_kamar . " (" . $kamar->tipe_kamar . ") " .
            "sebesar Rp " . number_format($kamar->harga_kamar, 0, ',', '.') . " telah berhasil diproses dengan metode pembayaran Transfer.\n\n" .
            "Status Transaksi: Lunas.\n" .
            "Tanggal Pembayaran: " . Carbon::createFromFormat('Y-m-d', $today)->isoFormat('D MMMM Y') . ".\n\n" .
            "Terima kasih telah melakukan pembayaran tepat waktu.\n\n" .
            "Salam hangat, \nAdmin Kost Putri Rosanty";
        $messageAdmin =
            "Nama Penghuni: " . $penghuni->nama_penghuni . "\n" .
            "WA Penghuni: " . $penghuni->telepon_penghuni . "\n\n" .
            "Kamar Penghuni: " . $kamar->nomor_kamar . " (" . $kamar->tipe_kamar . ")\n" .
            "Tagihan: " . Carbon::createFromFormat('m', $order->bulan_tagihan)->isoFormat('MMMM') . ' ' . Carbon::createFromFormat('Y', $order->tahun_tagihan)->isoFormat('Y') . "\n\n" .
            "Status Transaksi: Lunas\n" .
            "Metode Pembayaran: " . $paymentType . "\n" .
            "Nominal: Rp " . number_format($kamar->harga_kamar, 0, ',', '.') . "\n" .
            "Tanggal Pembayaran: " . Carbon::createFromFormat('Y-m-d', $today)->isoFormat('D MMMM Y');

        if (!$order) {
            return response()->json([
                'message'   => 'invalid order'
            ], 400);
        }

        if ($transactionStatus == 'settlement') {
            $order->status_transaksi    = 'Lunas';
            $order->metode_pembayaran   = 'Transfer';
            $order->tgl_pembayaran      = now();
            $order->save();

            $this->sendWA($penghuni->telepon_penghuni, $message);
            $this->sendWA('0895380947341', $messageAdmin);

            return response()->json(['success' => true]);
        } else if ($transactionStatus == 'capture') {
            $order->status_transaksi    = 'Lunas';
            $order->metode_pembayaran   = 'Transfer';
            $order->tgl_pembayaran      = now();
            $order->save();

            $this->sendWA($penghuni->telepon_penghuni, $message);
            $this->sendWA('0895380947341', $messageAdmin);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
    }

    public function handlePaymentExpire(Request $request)
    {
        $transaksi = Transaksi::where('snap_token', $request->snap_token)->first();

        if ($transaksi) {
            $penghuni = $transaksi->penghuni;
            $kamar = $transaksi->penghuni->sewaKamar->kamar;

            $messageAdmin =
                "Nama Penghuni: " . $penghuni->nama_penghuni . "\n" .
                "WA Penghuni: " . $penghuni->telepon_penghuni . "\n\n" .
                "Kamar Penghuni: " . $kamar->nomor_kamar . " (" . $kamar->tipe_kamar . ")\n" .
                "Tagihan: " . Carbon::createFromFormat('m', $transaksi->bulan_tagihan)->isoFormat('MMMM') . ' ' . Carbon::createFromFormat('Y', $transaksi->tahun_tagihan)->isoFormat('Y') . "\n\n" .
                "Status Transaksi: Expire \n" .
                "Nominal: Rp " . number_format($kamar->harga_kamar, 0, ',', '.') . "\n";

            $this->sendWA('0895380947341', $messageAdmin);
            return response()->json(['success' => true]);
        }
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

    // public function updateTransaksi(Request $request)
    // {
    //     $transaksi = Transaksi::where('snap_token', $request->snap_token)->first();
    //     $today = Carbon::now()->toDateString();

    //     if ($transaksi) {
    //         $transaksi->metode_pembayaran = 'Transfer';
    //         $transaksi->status_transaksi = 'Lunas';
    //         $transaksi->tgl_pembayaran = now();
    //         $transaksi->save();
    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.'], 404);
    // }
}
