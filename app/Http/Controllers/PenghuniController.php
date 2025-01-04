<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PenghuniController extends Controller
{
    public function dataTablePenghuni(Request $request)
    {
        if ($request->ajax()) {
            $penghuni = Penghuni::with('user')->orderBy('created_at', 'desc')->get();
            return DataTables::of($penghuni)
                ->addIndexColumn()
                ->addColumn('email', fn($row) => $row->user->email)
                ->addColumn('nama', fn($row) => $row->nama_penghuni)
                ->addColumn('nik', fn($row) => $row->nik_penghuni)
                ->addColumn('no_wa', fn($row) => $row->telepon_penghuni)
                ->editColumn(
                    'last_login',
                    fn($row) => $row->user->last_login
                        ? Carbon::createFromFormat('Y-m-d H:i:s', $row->user->last_login)->diffForHumans()
                        : 'Belum pernah login'
                )
                ->addColumn('action', fn($row) => '
                    <div class="dropdown d-inline">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opsi
                        </button>
                        <div class="dropdown-menu">'
                        . ($row->user_id !== null ?
                            '<a data-id="' . $row->id . '" data-nama="' . $row->nama_penghuni . '" class="dropdown-item has-icon resetAkun" href="javascript:;"><i class="fas fa-key"></i> Reset Akun</a>'
                            : '') .
                        '</div>
                    </div>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.penyewaan-kos.penghuni.index');
    }

    // public function destroy(string $id)
    // {
    //     $penghuni  = Penghuni::findOrFail($id);

    //     $sewa = $penghuni->sewaKamar->kamar->id;

    //     $kamar = Kamar::findOrFail($sewa);
    //     $kamar->update([
    //         'status_kamar'  => 'Tersedia'
    //     ]);

    //     if ($penghuni->user_id == null) {
    //         $penghuni->delete();
    //     } else {
    //         $user       = User::findOrFail($penghuni->user_id);
    //         $penghuni->delete();
    //         $user->delete();
    //     }

    //     return response()->json([
    //         'message'   => true
    //     ], 200);
    // }

    public function resetAkun(string $id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $password = 'KostRosanty00';

        $baseUrl = url('/');
        $message = "Hai " . $penghuni->nama_penghuni . ",\n\n" .
            "Kami ingin memberitahu Anda bahwa akun Anda telah berhasil di-reset. Berikut adalah informasi login baru Anda: \n\n" .
            "Email : " . $penghuni->user->email . "\n" .
            "Password : " . $password . "\n\n" .
            "Silakan gunakan informasi di atas untuk login di " . $baseUrl . ". Kami menyarankan Anda untuk segera mengubah password setelah masuk ke akun Anda untuk keamanan yang lebih baik. Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami dengan balas pesan ini. \n\n" .
            "Salam hangat, \nAdmin Kost Putri Rosanty";
        $this->sendWA($penghuni->telepon_penghuni, $message);

        $penghuni->user->update([
            'password'  => Hash::make($password),
            'text'      => $password
        ]);

        return response()->json([
            'message' => true
        ], 200);
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
}
