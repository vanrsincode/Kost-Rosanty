<?php

namespace App\Http\Controllers;

use App\Models\SewaKamar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penghuni = $user->penghuni;

        $sewakamar = SewaKamar::where('penghuni_id', $penghuni->id)->first();
        // $totalTagihan = $sewakamar->transaksi->sum('total_bayar');

        $transaksis = Transaksi::where('penghuni_id', $penghuni->id)->orderBy('bulan_tagihan', 'desc')->orderBy('tahun_tagihan', 'desc')->get();

        $totalTagihan = $transaksis ? $transaksis->where('status_transaksi', 'Belum Lunas')->sum('total_bayar') : 0;

        return view("admin-panel.pages.riwayat.index", [
            'penghuni'  => $penghuni,
            'sewakamar'     => $sewakamar,
            'totalTagihan'     => $totalTagihan,
            'transaksis'     => $transaksis,
        ]);
    }
}
