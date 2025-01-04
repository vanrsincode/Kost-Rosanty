<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AksesController extends Controller
{
    public function dataTablePengelola(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('id', '!=', 1)->whereNot('role', 2)->orderBy('created_at', 'desc')->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('nama', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->editColumn('sebagai', function ($row) {
                    if ($row->role == 1) {
                        return 'Administrator';
                    } elseif ($row->role == 2) {
                        return 'Penghuni';
                    } elseif ($row->role == 3) {
                        return 'Pemilik';
                    } else {
                        return 'Tidak diketahui';
                    }
                })
                ->editColumn('last_login', function ($row) {
                    if ($row->last_login) {
                        $lastLogin =  Carbon::createFromFormat('Y-m-d H:i:s', $row->last_login)->diffForHumans();
                    } else {
                        $lastLogin = 'Belum pernah login';
                    }

                    return $lastLogin;
                })
                ->addColumn('action', function ($row) {
                    if ($row->id !== 1) {
                        $btn = '<button data-id="' . $row->id . '" data-nama="' . $row->name . '"  class="btn btn-info btn-sm width-btn text-white resetAkun" title="Reset Akun">
                                    <i class="fas fa-key"></i>
                                </button> ';
                        $btn .= '<button data-id="' . $row->id . '" data-nama="' . $row->name . '" class="btn btn-danger btn-sm width-btn text-white deleteData" title="Hapus Data">
                                    <i class="far fa-trash-alt"></i>
                                </button>';
                        return $btn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index()
    {
        return view('admin-panel.pages.pengelola.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama'      => 'required',
                'email'     => 'required|unique:users,email,',
                'password'  => 'required',
                'sebagai'   => 'required'
            ],
            [
                'nama.required'     => 'Nama harus diisi.',
                'email.required'    => 'Email harus diisi.',
                'email.unique'      => 'Email sudah ada atau sudah terpakai.',
                'password.required' => 'Password harus diisi.',
                'sebagai.required'  => 'Harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors()
            ]);
        }

        $user = User::create([
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'text'      => $request->password,
            'role'      => $request->sebagai
        ]);

        return response()->json([
            'success'   => true
        ], 200);
    }

    public function show(Request $request, $id)
    {
        // if ($request->ajax()) {
        $user = User::findOrFail($id);

        return response()->json([
            'data'  => $user
        ]);
        // }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'nama'      => 'required',
                'email'     => 'required|unique:users,email,' . $user->id,
                'password'  => 'required',
                'sebagai'   => 'required'
            ],
            [
                'nama.required'     => 'Nama harus diisi.',
                'email.required'    => 'Email harus diisi.',
                'email.unique'      => 'Email sudah ada atau sudah terpakai.',
                'password.required' => 'Password harus diisi.',
                'sebagai.required'  => 'Harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors'    => $validator->errors()
            ]);
        }

        $user->update([
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'text'      => $request->password,
            'role'      => $request->sebagai
        ]);

        return response()->json([
            'success'   => true
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $request->validate(['password' => 'required']);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'Password salah.']);
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function resetAkun(string $id)
    {
        $user = User::findOrFail($id);
        $password = 'KostRosanty00';

        $user->update([
            'password'  => Hash::make($password),
            'text'      => $password
        ]);

        return response()->json(['message' => true], 200);
    }
}
