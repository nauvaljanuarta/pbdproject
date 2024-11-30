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

        // isi dengan logika login
    }
    public function registerview()
    {
        return view('auth.register');
    }
    public function register()
    {
        // isi dengan logika register
    }
    public function logout()
    {

    }
}
