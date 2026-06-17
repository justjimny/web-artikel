<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('admin.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Log activity
            ActivityLog::log('Login', 'Berhasil masuk ke sistem.');

            return $this->redirectBasedOnRole($user)->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::log('Logout', 'Keluar dari sistem.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Helper to redirect based on user role.
     */
    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.super.index');
        }

        return redirect()->route('admin.artikel.index');
    }
}
