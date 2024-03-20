<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            // Periksa status pengguna
            $user = Auth::user();
            if ($user->status == 1) {
                return redirect()->intended('/home');
            } else {
                Auth::logout(); // Logout jika status pengguna bukan 1
                return redirect()->back()->withErrors(['username' => 'Your account is not active']);
            }
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

    public function gantiPassword()
    {
        return view('auth.ganti-password');
    }

    public function saveGantiPassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|different:current_password',
                'confirm_password' => 'required|same:new_password',
            ]);

            $user = Auth::user();

            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);

                return redirect('logout');
            }

            return back()->with('error', 'Password lama tidak cocok');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
