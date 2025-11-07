<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        // Debug: Log request method dan data
        Log::info('Login attempt', [
            'method' => $request->method(),
            'email' => $request->input('email'),
            'has_password' => $request->has('password'),
            'all_data' => $request->all()
        ]);

        // Proses login untuk POST request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt($credentials)) {
            Log::info('Login successful', ['email' => $request->input('email')]);
            
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/admin/dashboard');
            }
        }

        Log::error('Login failed', ['email' => $request->input('email')]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin');
    }
}