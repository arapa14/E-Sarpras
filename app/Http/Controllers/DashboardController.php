<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Location;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $locations = Location::all();

        $user = Auth::user();
        $locations = Location::all();

        // Ambil pengaduan yang dibuat oleh user yang sedang login.
        $complaintsQuery = Complaint::where('user_id', $user->id);

        $totalComplaints    = $complaintsQuery->count();
        $complaintsPending  = (clone $complaintsQuery)->where('status', 'pending')->count();
        $complaintsProgress = (clone $complaintsQuery)->where('status', 'progress')->count();
        $complaintsCompleted = (clone $complaintsQuery)->where('status', 'selesai')->count();

        $data = compact(
            'user',
            'locations',
            'totalComplaints',
            'complaintsPending',
            'complaintsProgress',
            'complaintsCompleted'
        );
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
