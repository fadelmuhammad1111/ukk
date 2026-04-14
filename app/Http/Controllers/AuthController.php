<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 📄 Halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🔑 Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (auth()->user()->role === 'admin') {
                return view('dashboard');
            } else {
                return view('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ])->withInput();
    }

    // 🚪 Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
