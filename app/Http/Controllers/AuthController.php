<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function loginview()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('user')->where('username', $request->username)->first();

        if ($user && $request->password == $user->password) {
            // Log the user in using the user ID
            Auth::loginUsingId($user->iduser);

            // Redirect to dashboard after successful login
            return redirect('/dashboard')->with('success', 'Login berhasil.');
        }

        // Jika username atau password salah
        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('/')->with('success', 'Logout berhasil!');
    }

    public function registerview()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Logika register (tidak disertakan di sini)
    }
}
