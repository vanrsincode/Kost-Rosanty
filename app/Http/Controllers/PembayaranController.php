<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    public function dataTablePembayaran(Request $request)
    {
        if ($request->ajax()) {
            $transaksi = Transaksi::with('penghuni', 'penghuni.sewaKamar', 'penghuni.sewaKamar.kamar')->where('status_transaksi', 'Lunas')->orderBy('tgl_pembayaran', 'desc')->get();
            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return $row->penghuni->nama_penghuni;
                })
                ->editColumn('kamar', function ($row) {
                    return $row->penghuni->sewaKamar->kamar->nomor_kamar . '/' . $row->penghuni->sewaKamar->kamar->tipe_kamar;
                })
                ->editColumn('tagihan', function ($row) {
                    return Carbon::createFromFormat('m', $row->bulan_tagihan)->isoFormat('MMMM') . ' ' . Carbon::createFromFormat('Y', $row->tahun_tagihan)->isoFormat('Y');
                })
                ->editColumn('tarif', function ($row) {
                    return 'Rp. ' . number_format($row->penghuni->sewaKamar->kamar->harga_kamar, 0, ',', '.');
                })
                ->editColumn('metode', function ($row) {
                    return $row->metode_pembayaran;
                })
                ->editColumn('tanggal', function ($row) {
                    return Carbon::createFromFormat('Y-m-d', $row->tgl_pembayaran)->isoFormat('D MMMM Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button data-id="' . $row->id . '"  class="btn btn-success btn-sm width-btn text-white payCash" title="Bayar Tunai"><i class="far fa-money-bill-alt"></i></button> ';
                    $btn .= '<button data-id="' . $row->id . '" data-nama="' . $row->nama_fasilitas . '" class="btn btn-danger btn-sm width-btn text-white deleteData" title="Hapus Data"><i class="far fa-trash-alt"></i></button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.transaksi.pembayaran.index');
    }
}
