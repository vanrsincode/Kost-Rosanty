<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Feedback;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_penghuni    = Penghuni::select(DB::raw('COUNT(id) as total'))->get();
        $jumlah_fasilitas   = Fasilitas::select(DB::raw('COUNT(id) as total'))->get();
        $jumlah_kamar       = Kamar::select(DB::raw('COUNT(id) as total'))->get();
        $jumlah_feedback    = Feedback::select(DB::raw('COUNT(id) as total'))->get();

        // Grafik
        $currentYear = Carbon::now()->year;

        $transaksiBelumLunas = Transaksi::where('status_transaksi', 'Belum Lunas')
            ->where('tahun_tagihan', $currentYear)
            ->selectRaw('bulan_tagihan, SUM(total_bayar) as total')
            ->groupBy('bulan_tagihan')
            ->orderBy('bulan_tagihan', 'asc')
            ->get();

        $transaksiSudahLunas = Transaksi::where('status_transaksi', 'Lunas')
            ->where('tahun_tagihan', $currentYear)
            ->selectRaw('bulan_tagihan, SUM(total_bayar) as total')
            ->groupBy('bulan_tagihan')
            ->orderBy('bulan_tagihan', 'asc')
            ->get();

        // Prepare data for Chart.js
        $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $dataBelumLunas = array_fill(0, 12, 0);
        $dataSudahLunas = array_fill(0, 12, 0);

        foreach ($transaksiBelumLunas as $transaksi) {
            $dataBelumLunas[$transaksi->bulan_tagihan - 1] = $transaksi->total ?? 0;
        }

        foreach ($transaksiSudahLunas as $transaksi) {
            $dataSudahLunas[$transaksi->bulan_tagihan - 1] = $transaksi->total ?? 0;
        }

        // Penghuni
        $user = Auth::user();
        $penghuni = $user->penghuni ?? null;

        if ($penghuni) {
            $dashKamarPenghuni = $penghuni->sewaKamar->kamar->nomor_kamar . ' / ' . $penghuni->sewaKamar->kamar->tipe_kamar;

            $dashTarifPenghuni = $penghuni->sewaKamar->kamar->harga_kamar;

            $sewaKamar = $penghuni->sewaKamar;
            $transaksi = $penghuni ? $penghuni->transaksi()->orderBy('bulan_tagihan', 'asc')->orderBy('tahun_tagihan', 'asc')->get() : collect();

            $dashTotalBelumDibayar = $transaksi ? $transaksi->where('status_transaksi', 'Belum Lunas')->sum('total_bayar') : 0;
        } else {
            $dashKamarPenghuni = null;
            $dashTarifPenghuni = null;
            $dashTotalBelumDibayar = 0;

            $transaksi = collect();
        }

        return view('admin-panel.pages.dashboard.index', [
            'jumlah_penghuni' => $jumlah_penghuni,
            'jumlah_fasilitas' => $jumlah_fasilitas,
            'jumlah_kamar' => $jumlah_kamar,
            'jumlah_feedback' => $jumlah_feedback,
            'dashKamarPenghuni' => $dashKamarPenghuni,
            'dashTarifPenghuni' => $dashTarifPenghuni,
            'dashTotalBelumDibayar' => $dashTotalBelumDibayar,
            'currentYear'   => $currentYear,
            'bulan'     => $bulan,
            'dataBelumLunas'    => $dataBelumLunas,
            'dataSudahLunas'    => $dataSudahLunas,
            'transaksi' => $transaksi,
        ]);
    }
}
