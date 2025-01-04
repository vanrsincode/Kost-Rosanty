<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kamar;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    public function dataSelectFasilitas(Request $request)
    {
        if ($request->ajax()) {
            $term = $request->input('term');

            $fasilitas = Fasilitas::where('nama_fasilitas', 'like', '%' . $term . '%')
                // ->orderBy('nama_fasilitas', 'asc')
                // ->limit(5)
                ->get();

            return response()->json($fasilitas);
        }
    }

    public function dataSelectKamar(Request $request)
    {
        if ($request->ajax()) {
            $term = $request->input('term');

            // $kamar = Kamar::where('status_kamar', 'Tersedia')
            // ->where(function ($query) use ($term) {
            //     $query->where('nomor_kamar', 'like', '%' . $term . '%')
            //         ->orWhere('tipe_kamar', 'like', '%' . $term . '%');
            // })
            //     ->orderBy('nomor_kamar', 'asc')
            //     // ->limit(5)
            //     ->get();

            $kamar = Kamar::with('sewaKamar:id,kamar_id,penghuni_id', 'sewaKamar.penghuni:id,nama_penghuni')
                ->where(function ($query) use ($term) {
                    $query->where('nomor_kamar', 'like', '%' . $term . '%')
                        ->orWhere('tipe_kamar', 'like', '%' . $term . '%')
                        ->orWhereHas('sewaKamar.penghuni', function ($query) use ($term) {
                            $query->where('nama_penghuni', 'like', '%' . $term . '%');
                        });
                })
                ->orderBy('nomor_kamar', 'asc')
                // ->limit(5)
                ->get();

            return response()->json($kamar);
        }
    }
}
