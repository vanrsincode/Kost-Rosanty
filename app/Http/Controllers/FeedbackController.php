<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
{
    public function dataTableFeedbackADM(Request $request)
    {
        if ($request->ajax()) {
            $feedback = Feedback::with('penghuni')->orderBy('created_at', 'desc')->get();
            return DataTables::of($feedback)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return $row->penghuni->nama_penghuni;
                })
                ->editColumn('tanggal', function ($row) {
                    return Carbon::createFromFormat('Y-m-d', $row->tanggal)->isoFormat('DD MMMM Y');;
                })
                ->make(true);
        }
    }

    public function dataTableFeedbackPHN(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $rolePenghuni = $user->penghuni;
            $feedback = Feedback::where('penghuni_id', $rolePenghuni->id)->orderBy('created_at', 'desc')->get();
            return DataTables::of($feedback)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($row) {
                    return Carbon::createFromFormat('Y-m-d', $row->tanggal)->isoFormat('DD MMMM Y');;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '"  class="btn btn-warning btn-sm width-btn text-white editData" title="Edit Data"><i class="far fa-edit"></i></button> ';
                    $btn .= '<button type="button" data-id="' . $row->id . '" data-nama="' . $row->nama_fasilitas . '" class="btn btn-danger btn-sm width-btn text-white deleteData" title="Hapus Data"><i class="far fa-trash-alt"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function indexADM()
    {
        return view("admin-panel.pages.feedback.index");
    }

    public function index()
    {
        return view('admin-panel.pages.feedback.penghuni.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pesan' => 'required'
            ],
            [
                'pesan.required' => 'Pesan harus diisi'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        $rolePenghuni = $user->penghuni;
        $today = Carbon::now()->toDateString();

        Feedback::create([
            'tanggal'       => $today,
            'pesan'         => $request->pesan,
            'penghuni_id'   => $rolePenghuni->id,
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $rolePenghuni = $user->penghuni;

            $feedback = Feedback::where('penghuni_id', $rolePenghuni->id)->findOrFail($id);

            return response()->json([
                'data'  => $feedback,
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pesan' => 'required'
            ],
            [
                'pesan.required' => 'Pesan harus diisi'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        $rolePenghuni = $user->penghuni;

        $feedback = Feedback::where('penghuni_id', $rolePenghuni->id)->findOrFail($id);
        $feedback->update([
            'pesan' => $request->pesan,
        ]);

        return response()->json([
            'success'   => true,
        ], 200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $rolePenghuni = $user->penghuni;

        $feedback = Feedback::where('penghuni_id', $rolePenghuni->id)->findOrFail($id);
        $feedback->delete();

        return response()->json([
            'success'   => true,
        ], 200);
    }
}
