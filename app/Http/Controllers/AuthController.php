<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function login()
    {
        $name = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        return view('auth.login', compact('name', 'logo'));
    }

    /**
     * Proses login.
     */
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Flash message sukses
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        }

        // Flash message error
        return redirect()->back()->with('error', 'Email atau password salah!');
    }

    /**
     * Proses registrasi.
     */
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'role'       => 'required|string',
            'whatsapp'   => 'required|numeric',
            'password'   => 'required|min:8|confirmed',
            // Pastikan input "password_confirmation" ada di form
        ]);

        // Membuat user baru dengan role default 'user'
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'whatsapp' => $request->whatsapp,
            'role'     => $request->input('role', 'user'),
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah registrasi berhasil
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
