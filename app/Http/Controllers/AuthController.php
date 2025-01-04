<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect()->intended('/');
        }

        $currentHour = Carbon::now()->hour;

        if ($currentHour >= 5 && $currentHour < 12) {
            $greeting = "Good Morning";
        } elseif ($currentHour >= 12 && $currentHour < 17) {
            $greeting = "Good Afternoon";
        } elseif ($currentHour >= 17 && $currentHour < 21) {
            $greeting = "Good Evening";
        } else {
            $greeting = "Good Night";
        }

        return view('admin-panel.auth.login', ['greeting' => $greeting]);
    }

    public function proses(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'password.required' => 'Password tidak boleh kosong!'
            ]
        );

        $email = $request->input('email');
        $password = $request->input('password');

        // $field = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credential = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credential)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user instanceof \App\Models\User) {
                $user->last_login = now();
                $user->save();
            } else {
                dd(get_class($user));
            }

            if ($user) {
                return redirect()->intended('/');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            // 'email' => 'Maaf username atau email, atau password Anda salah'
            'email' => 'Oops! Sepertinya kita punya masalah di sini. Kredensialmu tidak sesuai. Yuk, coba lagi! Ingat, pintu ke dunia kami selalu terbuka untukmu dengan kunci yang tepat.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect('/login');
    }
}
