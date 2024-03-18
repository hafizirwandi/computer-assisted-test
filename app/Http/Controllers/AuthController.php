<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginFormSiswa()
    {
        return view('layouts.login.siswa');
    }
    public function loginFormAdmin()
    {
        return view('layouts.login.app');
    }
    public function auth(Request $request)
    {

        //dd($request->all());
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember'); // Memeriksa apakah opsi Remember Me dicentang

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed...
            return redirect()->intended('/home');
        }

        return redirect()->back()->withInput()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout(Request $request)
    {
        $guard = Auth::getDefaultDriver();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($guard == 'web') {
            return redirect('/login-admin');
        } elseif ($guard == 'siswa') {
            return redirect('/login');
        } else {
            // Handle guard lainnya jika diperlukan
            return redirect('/login');
        }
    }
}
