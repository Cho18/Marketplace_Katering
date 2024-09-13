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
        // Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // If authentication is successful, regenerate the session
            $request->session()->regenerate();

            // Redirect to the dashboard
            return redirect()->intended('dashboard')->with('success', 'Login successful');
        }

        // If authentication fails, redirect back to the login form with an error message
        return back()->with('failed', 'Invalid credentials. Please try again.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session to log out the user securely
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
