<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $apk = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;

        $locations = Location::all();

        $data = compact('user', 'apk', 'logo', 'locations');
        switch ($user->role) {
            case 'superAdmin':
                return view('superadmin.dashboard');
            case 'admin':
                return view('admin.dashboard');
            case 'user':
                return view('user.dashboard', $data);
            default:
                return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }
    }
}
