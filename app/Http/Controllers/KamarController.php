<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KamarController extends Controller
{
    public function dataTableKamar(Request $request)
    {
        if ($request->ajax()) {
            $kamar = Kamar::with(['fasilitas:id,nama_fasilitas'])->select('id', 'nomor_kamar as no_kamar', 'tipe_kamar as tipe', 'harga_kamar as harga', 'ket_kamar as keterangan', 'status_kamar as status')->get();
            return DataTables::of($kamar)
                ->addIndexColumn()
                ->editColumn('harga', fn($row) => 'Rp. ' . number_format($row['harga'], 0, '.', ','))
                ->addColumn('fasilitas', function ($kamar) {
                    if ($kamar->fasilitas->isEmpty()) {
                        return 'Tanpa Fasilitas';
                    }
                    $fasilitas = $kamar->fasilitas->pluck('nama_fasilitas')->toArray();
                    $chunks = array_chunk($fasilitas, 2);
                    $formattedFasilitas = '';
                    foreach ($chunks as $chunk) {
                        $formattedFasilitas .= implode(', ', $chunk) . '\n';
                    }

                    return rtrim($formattedFasilitas, '\n');
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    if ($status == 'Tersedia') {
                        return '<span class="status-tersedia" style="color: #28a745;">' . $status . '</span>';
                    } elseif ($status == 'Terpakai') {
                        return '<span class="status-terpakai" style="color: #dc3545;">' . $status . '</span>';
                    } else {
                        return '<span class="status-default" style="color: #6c757d;">' . $status . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    if ($row->status !== 'Terpakai') {
                        $btn = '<button type="button" data-id="' . $row->id . '"  class="btn btn-warning btn-sm width-btn text-white" title="Edit Data" id="editData"><i class="far fa-edit"></i></button> ';
                        $btn .= '<button type="button" data-id="' . $row->id . '" data-nama="' . $row->no_kamar . ' ' . $row->tipe . '" class="btn btn-danger btn-sm width-btn text-white" title="Hapus Data" id="deleteData"><i class="far fa-trash-alt"></i></button>';
                        return $btn;
                    }

                    $btn = '<button type="button" data-id="' . $row->id . '"  class="btn btn-warning btn-sm width-btn text-white" title="Edit Data" id="editData"><i class="far fa-edit"></i></button> ';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.master.kamar.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_kamar'    => 'required|unique:kamar,nomor_kamar',
                'tipe'        => 'required',
                'harga'       => 'required',
                // 'fasilitas'   => 'required|array|min:1', // Minimal satu fasilitas dipilih
                // 'fasilitas.*'   => 'required|array|min:1',
                // 'fasilitas.*' => 'exists:fasilitas,id'
            ],
            [
                'no_kamar.unique'      => 'Nomor Kamar sudah ada.',
                'no_kamar.required'    => 'Nomor Kamar harus diisi.',
                'tipe.required'        => 'Tipe Kamar harus diisi.',
                'harga.required'       => 'Harga Kamar harus diisi.',
                // 'fasilitas.required'   => 'Pilih setidaknya satu fasilitas.',
                // 'fasilitas.min'        => 'Pilih setidaknya satu fasilitas.',
                // 'fasilitas.*.required'   => 'Pilih setidaknya satu fasilitas.',
                // 'fasilitas.*.exists'   => 'Salah satu fasilitas yang dipilih tidak valid.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors()
            ]);
        }

        $moneyWithoutComma = str_replace(',', '', $request->harga);
        $harga = (int)$moneyWithoutComma;

        $kamar = Kamar::create([
            'nomor_kamar'   => $request->no_kamar,
            'tipe_kamar'    => $request->tipe,
            'harga_kamar'   => $harga,
            'ket_kamar'     => $request->keterangan,
            'status_kamar'  => 'Tersedia',
        ]);

        // Attach fasilitas ke kamar
        $kamar->fasilitas()->attach($request->selfasilitas);

        return response()->json([
            'success' => true
        ], 200);
    }

    public function show(Request $request, string $id)
    {
        if ($request->ajax()) {
            $kamar = Kamar::with(['fasilitas:id,nama_fasilitas'])->select('id', 'nomor_kamar as no_kamar', 'tipe_kamar as tipe', 'harga_kamar as harga', 'ket_kamar as keterangan', 'status_kamar')->findOrFail($id);

            return response()->json([
                'data'  => $kamar
            ], 200);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_kamar'    => 'required|unique:kamar,nomor_kamar,' . $id,
                'tipe'        => 'required',
                'harga'       => 'required',
                // 'fasilitas'   => 'required|array|min:1', // Minimal satu fasilitas dipilih
                // // 'fasilitas.*'   => 'required|array|min:1',
                // 'fasilitas.*' => 'exists:fasilitas,id'
            ],
            [
                'no_kamar.unique'      => 'Nomor Kamar sudah ada.',
                'no_kamar.required'    => 'Nomor Kamar harus diisi.',
                'tipe.required'        => 'Tipe Kamar harus diisi.',
                'harga.required'       => 'Harga Kamar harus diisi.',
                // 'fasilitas.required'   => 'Pilih setidaknya satu fasilitas.',
                // 'fasilitas.min'        => 'Pilih setidaknya satu fasilitas.',
                // // 'fasilitas.*.required'   => 'Pilih setidaknya satu fasilitas.',
                // 'fasilitas.*.exists'   => 'Salah satu fasilitas yang dipilih tidak valid.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors()
            ]);
        }

        $moneyWithoutComma = str_replace(',', '', $request->harga);
        $harga = (int)$moneyWithoutComma;

        $kamar = Kamar::findOrFail($id);

        $kamar->update([
            'nomor_kamar'   => $request->no_kamar,
            'tipe_kamar'    => $request->tipe,
            'harga_kamar'   => $harga,
            'ket_kamar'     => $request->keterangan,
        ]);

        $kamar->fasilitas()->sync($request->selfasilitas);

        return response()->json([
            'success' => true
        ], 200);
    }

    public function destroy(Request $request, string $id)
    {
        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah.']);
        }

        $fasilitas = Kamar::find($id);
        if ($fasilitas) {
            $fasilitas->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
