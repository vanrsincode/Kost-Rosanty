<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Admin dan Pemilik
    public function indexProfile()
    {
        return view('admin-panel.pages.profile.index');
    }

    public function getDataProfile()
    {
        $idSession = auth()->user()->id;
        $profile = User::where('id', $idSession)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Pribadi',
            'data'      => $profile
        ]);
    }

    public function updateProfile(Request $request, User $profile)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nameProfile'      => 'required',
                'emailProfile'     => 'required|unique:users,email,' . $profile->id,
                'passwordProfile'  => 'required|min:8',
            ],
            [
                'nameProfile.required'       => 'Nama Lengkap tidak boleh kosong!',
                'emailProfile.unique'        => 'Email sudah digunakan!',
                'emailProfile.required'      => 'Email tidak boleh kosong!',
                'passwordProfile.required'   => 'Password tidak boleh kosong!',
                'passwordProfile.min'        => 'Password harus minimal 8 karakter!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $textValue = $profile->id == 1 ? null : $request->passwordProfile;

        $profile->update([
            'name'      => $request->nameProfile,
            'email'     => $request->emailProfile,
            'password'  => Hash::make($request->passwordProfile),
            'text'     => $textValue
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $profile
        ], 200);
    }

    // Profile Penghuni
    public function indexProfilePenghuni()
    {
        return view('admin-panel.pages.profile.penghuni');
    }

    public function getDataProfilePenghuni()
    {
        $idSession = auth()->user()->id;
        $profile = User::with('penghuni')->where('id', $idSession)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Pribadi',
            'data'      => $profile
        ]);
    }

    public function updateProfilePenghuni(Request $request, string $id)
    {
        $profile = User::with('penghuni')->findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'nameProfile'           => 'required',
                'emailProfile'          => 'required|email|unique:users,email,' . $profile->id,
                'passwordProfile'       => 'required|min:8',
                'nik'                   => 'required|max:16',
                'tempat_lahir'          => 'required',
                'tanggal_lahir'         => 'required',
                'no_wa'                 => 'required|max:13',
                'alamat'                => 'required',
            ],
            [
                'nameProfile.required'          => 'Nama Lengkap tidak boleh kosong!',
                'emailProfile.unique'           => 'Email sudah digunakan!',
                'emailProfile.required'         => 'Email tidak boleh kosong!',
                'passwordProfile.required'      => 'Password tidak boleh kosong!',
                'passwordProfile.min'           => 'Password harus minimal 8 karakter!',
                'nik.required'                  => 'NIK tidak boleh kosong!',
                'nik.max'                       => 'NIK tidak boleh lebih dari 16 karakter!',
                'no_wa.required'                => 'Nomor WhatsApp tidak boleh kosong!',
                'no_wa.max'                     => 'Nomor WhatsApp tidak boleh lebih dari 16 karakter!',
                'tempat_lahir.required'         => 'Tempat Lahir tidak boleh kosong!',
                'tanggal_lahir.required'        => 'Tanggal Lahir tidak boleh kosong!',
                'alamat.required'               => 'Alamat tidak boleh kosong!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $penghuni = Penghuni::where('user_id', $profile->id)->firstOrFail();

        $profile->update([
            'name'      => $request->nameProfile,
            'email'     => $request->emailProfile,
            'password'  => Hash::make($request->passwordProfile),
            'text'      => $request->passwordProfile
        ]);

        $penghuni->update([
            'nama_penghuni'     => $request->nameProfile,
            'nik_penghuni'      => $request->nik,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'telepon_penghuni'  => $request->no_wa,
            'alamat_penghuni'   => $request->alamat
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $profile
        ], 200);
    }
}
