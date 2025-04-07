<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Question;
use App\Models\Faq;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika role admin, tampilkan dashboard admin dengan data-data lengkap
        if ($user->role === 'admin') {
            // Data Pengaduan (seluruh user)
            $totalComplaints    = Complaint::count();
            $complaintsPending  = Complaint::where('status', 'pending')->count();
            $complaintsProgress = Complaint::where('status', 'progress')->count();
            $complaintsCompleted = Complaint::where('status', 'selesai')->count();

            // Data Pertanyaan
            $totalQuestions    = Question::count();
            $questionsPending  = Question::where('status', 'pending')->count();
            $questionsApproved = Question::where('status', 'approved')->count();
            $questionsRejected = Question::where('status', 'rejected')->count();

            // Data FAQ
            $totalFaqs      = Faq::count();
            $faqsPublished  = Faq::where('status', 'published')->count();
            $faqsDraft      = Faq::where('status', 'draft')->count();

            // Analytics tambahan, misalnya total pengguna
            $totalUsers = User::count();

            // Jika diperlukan data lokasi atau data setting lainnya, bisa juga ditambahkan:
            $locations = Location::all();

            $data = compact(
                'totalComplaints',
                'complaintsPending',
                'complaintsProgress',
                'complaintsCompleted',
                'totalQuestions',
                'questionsPending',
                'questionsApproved',
                'questionsRejected',
                'totalFaqs',
                'faqsPublished',
                'faqsDraft',
                'totalUsers',
                'locations'
            );

            return view('admin.dashboard', $data);
        }

        // Jika bukan admin, redirect sesuai role masing-masing
        switch ($user->role) {
            case 'superAdmin':
                return view('superadmin.dashboard');
            case 'user':
                // Data untuk user hanya pengaduan milik sendiri
                $complaintsQuery = Complaint::where('user_id', $user->id);
                $data = [
                    'user'                => $user,
                    'locations'           => Location::all(),
                    'totalComplaints'     => $complaintsQuery->count(),
                    'complaintsPending'   => (clone $complaintsQuery)->where('status', 'pending')->count(),
                    'complaintsProgress'  => (clone $complaintsQuery)->where('status', 'progress')->count(),
                    'complaintsCompleted' => (clone $complaintsQuery)->where('status', 'selesai')->count(),
                ];
                return view('user.dashboard', $data);
            default:
                return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }
    }
}
