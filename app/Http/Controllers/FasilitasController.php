<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FasilitasController extends Controller
{
    public function dataTableFasilitas(Request $request)
    {
        if ($request->ajax()) {
            $fasilitas = Fasilitas::orderBy('created_at', 'desc')->get();
            return DataTables::of($fasilitas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '"  class="btn btn-warning btn-sm width-btn text-white" title="Edit Data" id="editData"><i class="far fa-edit"></i></button> ';
                    $btn .= '<button type="button" data-id="' . $row->id . '" data-nama="' . $row->nama_fasilitas . '" class="btn btn-danger btn-sm width-btn text-white" title="Hapus Data" id="deleteData"><i class="far fa-trash-alt"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.master.fasilitas.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fasilitas' => 'required'
            ],
            [
                'fasilitas.required' => 'Fasilitas harus diisi'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors()
            ]);
        }

        Fasilitas::create([
            'nama_fasilitas'    => $request->fasilitas
        ]);

        return response()->json([
            'success'   => true
        ], 200);
    }

    public function show(Request $request, string $id)
    {
        if ($request->ajax()) {
            $fasilitas = Fasilitas::findOrFail($id);
            return response()->json([
                'data'      => $fasilitas
            ], 200);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fasilitas' => 'required'
            ],
            [
                'fasilitas.required' => 'Fasilitas harus diisi'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $fasilitas = Fasilitas::findOrFail($id);

        $fasilitas->update([
            'nama_fasilitas' => $request->fasilitas
        ]);

        return response()->json([
            'success' => true
        ], 200);
    }

    public function destroy(Request $request, string $id)
    {
        // $fasilitas = Fasilitas::findOrFail($id);
        // $fasilitas->delete();

        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah.']);
        }

        $fasilitas = Fasilitas::find($id);
        if ($fasilitas) {
            $fasilitas->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
