<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'superAdmin':
                return view('superadmin.dashboard');
            case 'admin':
                return view('admin.dashboard');
            case 'user':
                return view('user.dashboard');
            default:
                return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }
    }
}
