<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     */
    public function index()
    {
        return view('authenticate.register');
    }

    /**
     * Handle the registration form submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'status'        => 'required|in:Customer,Merchant',
        ], [
            'name.required'          => 'Nama diperlukan.',
            'name.string'            => 'Nama harus berupa string.',
            'name.max'               => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required'         => 'Email diperlukan.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah digunakan.',
            'password.required'      => 'Kata sandi diperlukan.',
            'password.min'           => 'Kata sandi harus memiliki minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
            'status.required'        => 'Status diperlukan.',
            'status.in'              => 'Status harus salah satu dari: Customer, Merchant.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->status === 'Customer' ? 1 : 2,
        ]);

        return redirect('/login')->with('success', 'Pendaftaran akun telah berhasil');
    }
}
