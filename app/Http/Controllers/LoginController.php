<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function index()
    {
        return view('authenticate.login');
    }

    /**
     * Handle the login form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6', 
        ], [
            'email.required'        => 'Alamat email diperlukan.',
            'email.email'           => 'Format email tidak valid.',
            'password.required'     => 'Kata sandi diperlukan.',
            'password.min'          => 'Kata sandi harus terdiri dari minimal 6 karakter.',
        ]);

        // Cek kredensial login
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended('menu')->with('success', 'Login berhasil');
        }

        return back()->with('failed', 'Gagal login')->withInput();
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
