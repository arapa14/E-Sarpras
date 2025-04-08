<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Question;
use App\Models\Faq;
use App\Models\User;
use App\Models\Location;
use App\Models\Setting; // Asumsikan Anda memiliki model Setting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Untuk role admin, gunakan tampilan dashboard admin (seperti sebelumnya)
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

            // Data lokasi
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

        // Untuk role superAdmin, tampilkan dashboard analitik dengan data lengkap
        if ($user->role === 'superAdmin') {
            // Data Pengaduan
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

            // Data User
            $totalUsers = User::count();

            // Data Lokasi
            $locations = Location::all();

            // Data Settings (asumsi ada tabel settings dan model Setting)
            $totalSettings = Setting::count();

            // Anda bisa menambahkan analitik lain, misalnya log aktivitas, statistik session, dsb

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
                'locations',
                'totalSettings'
            );

            return view('superadmin.dashboard', $data);
        }

        // Jika role user, tampilkan dashboard milik user (pengaduan sendiri)
        if ($user->role === 'user') {
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
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
    }
}
