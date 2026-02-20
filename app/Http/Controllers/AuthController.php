<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.email' => 'Username harus berformat email',
            'password.required' => 'Password wajib diisi',
        ]);

        // Find user by username
        $user = User::where('username', $request->username)
                    ->where('delete_at', 0)
                    ->first();

        // Check if user exists and password is correct (MD5)
        if ($user && md5($request->password) === $user->password) {
            Auth::login($user, $request->remember ? true : false);
            
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}