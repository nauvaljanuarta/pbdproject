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

        // Query untuk mencari user dengan username
        $user = DB::table('user')->where('username', $request->username)->first();


        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            $user = Auth::user();
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
        return redirect('/login')->with('success', 'Logout berhasil!');
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
