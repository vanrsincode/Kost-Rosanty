<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {
        return view("admin-panel.pages.laporan.index");
    }

    public function filter(Request $request)
    {
        try {
            // Mengambil nilai input
            $startMonthInput = $request->input('start_month');
            $endMonthInput = $request->input('end_month');

            // Mengubah input menjadi objek Carbon
            $startMonth = $startMonthInput ? Carbon::parse($startMonthInput)->startOfMonth() : null;
            $endMonth = $endMonthInput ? Carbon::parse($endMonthInput)->endOfMonth() : null;

            // Memulai query dasar
            $query = Transaksi::with('penghuni', 'penghuni.sewaKamar', 'penghuni.sewaKamar.kamar')->orderBy('bulan_tagihan', 'desc')->orderBy('tahun_tagihan', 'desc');

            // Menyesuaikan query berdasarkan input
            if ($startMonth && $endMonth) {
                $query->where(function ($query) use ($startMonth, $endMonth) {
                    $query->where(function ($query) use ($startMonth) {
                        $query->where('tahun_tagihan', $startMonth->year)
                            ->where('bulan_tagihan', '>=', $startMonth->month);
                    })->where(function ($query) use ($endMonth) {
                        $query->where('tahun_tagihan', $endMonth->year)
                            ->where('bulan_tagihan', '<=', $endMonth->month);
                    });
                });
            } elseif ($startMonth) {
                $query->where(function ($query) use ($startMonth) {
                    $query->where('tahun_tagihan', $startMonth->year)
                        ->where('bulan_tagihan', $startMonth->month);
                });
            } elseif ($endMonth) {
                $query->where(function ($query) use ($endMonth) {
                    $query->where('tahun_tagihan', $endMonth->year)
                        ->where('bulan_tagihan', $endMonth->month);
                });
            } else {
                $query->whereRaw('false');
            }

            // Mendapatkan hasil query
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return $row->penghuni->nama_penghuni;
                })
                ->editColumn('kamar', function ($row) {
                    return $row->penghuni->sewaKamar->kamar->nomor_kamar . '/' . $row->penghuni->sewaKamar->kamar->tipe_kamar;
                })
                ->editColumn('tarif', function ($row) {
                    return 'Rp. ' . number_format($row->penghuni->sewaKamar->kamar->harga_kamar, 0, ',', '.');
                })
                ->editColumn('tagihan', function ($row) {
                    return Carbon::create($row->tahun_tagihan, $row->bulan_tagihan, 1)->isoFormat('MMMM YYYY');
                })
                ->editColumn('status_pembayaran', function ($transaksi) {
                    return $transaksi->status_transaksi;
                })
                ->editColumn('metode_pembayaran', function ($transaksi) {
                    return $transaksi->metode_pembayaran ?? 'Belum ada';
                })
                ->make(true);
        } catch (\Exception $e) {
            // Tangani kesalahan jika parsing input gagal
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function cetakPDF(Request $request)
    {
        try {
            $startMonthInput = $request->input('start_month');
            $endMonthInput = $request->input('end_month');

            $startMonth = $startMonthInput ? Carbon::parse($startMonthInput)->startOfMonth() : null;
            $endMonth = $endMonthInput ? Carbon::parse($endMonthInput)->endOfMonth() : null;

            $query = Transaksi::with('penghuni', 'penghuni.sewaKamar', 'penghuni.sewaKamar.kamar')->orderBy('bulan_tagihan', 'desc')->orderBy('tahun_tagihan', 'desc');

            if ($startMonth && $endMonth) {
                $query->where(function ($query) use ($startMonth, $endMonth) {
                    $query->where(function ($query) use ($startMonth) {
                        $query->where('tahun_tagihan', $startMonth->year)
                            ->where('bulan_tagihan', '>=', $startMonth->month);
                    })->where(function ($query) use ($endMonth) {
                        $query->where('tahun_tagihan', $endMonth->year)
                            ->where('bulan_tagihan', '<=', $endMonth->month);
                    });
                });
            } elseif ($startMonth) {
                $query->where(function ($query) use ($startMonth) {
                    $query->where('tahun_tagihan', $startMonth->year)
                        ->where('bulan_tagihan', $startMonth->month);
                });
            } elseif ($endMonth) {
                $query->where(function ($query) use ($endMonth) {
                    $query->where('tahun_tagihan', $endMonth->year)
                        ->where('bulan_tagihan', $endMonth->month);
                });
            } else {
                $query->whereRaw('false');
            }

            $data = $query->get();

            $pdf = Pdf::loadView('admin-panel.pages.laporan.pdf', compact('data', 'startMonth', 'endMonth'));
            return $pdf->download('laporan-transaksi.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
