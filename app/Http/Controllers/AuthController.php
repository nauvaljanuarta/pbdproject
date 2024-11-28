<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginview()
    {
        return view('auth.login');
    }
    public function login()
    {

        return view('auth.login');
    }
    public function registerview()
    {
        return view('auth.register');
    }
    public function register()
    {
        return view('auth.login', compact('barang', 'satuan'));
    }
    public function logout()
    {
        return view('auth.login', compact('barang', 'satuan'));
    }
}
