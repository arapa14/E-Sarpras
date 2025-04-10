<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
     // Tampilkan halaman lupa password
     public function showForgotForm()
     {
         return View('auth.forgot-password');
     }
 
     // Kirim email reset password
     public function sendResetLinkEmail(Request $request)
     {
         // Validasi input email
         $request->validate([
             'email' => 'required|email|exists:users,email',
         ], [
             'email.exists' => 'Email tidak terdaftar atau tidak valid.',
         ]);        
 
         // Buat token random (plain token)
         $token = Str::random(60);
 
         // Simpan token ke tabel password_resets (gunakan updateOrInsert untuk menghindari duplikasi)
         DB::table('password_reset_tokens')->updateOrInsert(
             ['email' => $request->email],
             [
                 'token'      => Hash::make($token),
                 'created_at' => Carbon::now()
             ]
         );
 
         // Buat link reset password (dengan token dan email sebagai query parameter)
         $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
 
         // Ambil data user berdasarkan email
         $user = User::where('email', $request->email)->first();
 
         // Kirim email menggunakan Mailtrap (email view akan dibuat di langkah selanjutnya)
         Mail::send('emails.forgot-password', [
             'resetLink' => $resetLink,
             'user'      => $user
         ], function ($message) use ($request) {
             $message->to($request->email);
             $message->subject('Reset Password');
         });
 
         return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
     }
 
     // Tampilkan form reset password
     public function showResetForm(Request $request, $token)
     {
         // Ambil email dari query string
         $email = $request->query('email');
         return view('auth.reset-password', compact('token', 'email'));
     }
 
     // Proses reset password
     public function resetPassword(Request $request)
     {
         // Validasi input
         $request->validate([
             'email'                 => 'required|email|exists:users,email',
             'token'                 => 'required',
             'password'              => 'required|confirmed|min:6',
         ]);
 
         // Ambil record token dari tabel password_resets
         $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();
         if (!$record) {
             return back()->withErrors(['email' => 'Permintaan reset password tidak ditemukan.']);
         }
 
         // Verifikasi token dengan Hash::check (token di database sudah di-hash)
         if (!Hash::check($request->token, $record->token)) {
             return back()->withErrors(['token' => 'Token tidak valid atau telah kedaluwarsa.']);
         }
 
         // Update password user
         $user = User::where('email', $request->email)->first();
         $user->password = Hash::make($request->password);
         $user->save();
 
         // Hapus record token dari tabel password_resets
         DB::table('password_reset_tokens')->where('email', $request->email)->delete();
 
         return redirect()->route('login')->with('success', 'Password berhasil diubah. Silahkan login.');
     }
}
