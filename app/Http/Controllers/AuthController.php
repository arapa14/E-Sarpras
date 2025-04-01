<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $name = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        $img = Setting::where('key', 'main_image')->first()->value;
        $faqs = Faq::all();

        $data = compact('name', 'logo', 'faqs', 'img');
        return view('landing', $data);
    }

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
        return redirect()->back()->withInput()->with('error', 'Email atau password salah!');
    }

    /**
     * Proses registrasi.
     */
    public function registerSubmit(Request $request)
    {
        try {
            $request->validate([
                'name'       => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email',
                'whatsapp'   => 'required|numeric|:min:10',
                'password'   => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'whatsapp' => $request->whatsapp,
                'role'     => $request->input('role', 'user'),
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi.')
                ->with('form', 'register'); // flag untuk tetap di tab register
        }
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
