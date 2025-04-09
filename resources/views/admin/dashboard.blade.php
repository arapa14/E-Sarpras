@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 md:p-8">
        <div class="container mx-auto">
            <!-- Header dengan Background Gradient -->
            <header class="mb-6 py-6 bg-gradient-to-r from-blue-500 to-teal-500 rounded-xl shadow-lg text-center text-white">
                <h1 class="text-3xl font-extrabold mb-2">Dashboard Admin</h1>
                <p class="text-base">Selamat datang, {{ Auth::user()->name }}.</p>
            </header>

            <!-- Grid Utama: Tampilkan dalam satu kolom untuk mobile -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Kartu Data Pengaduan -->
                <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Data Pengaduan</h2>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-blue-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Total Pengaduan</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $totalComplaints }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pengaduan Pending</span>
                            <span class="text-2xl font-bold text-yellow-600">{{ $complaintsPending }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-orange-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pengaduan On Progress</span>
                            <span class="text-2xl font-bold text-orange-600">{{ $complaintsProgress }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-green-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pengaduan Selesai</span>
                            <span class="text-2xl font-bold text-green-600">{{ $complaintsCompleted }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kartu Data Pertanyaan -->
                <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Data Pertanyaan</h2>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-blue-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Total Pertanyaan</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $totalQuestions }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pertanyaan Pending</span>
                            <span class="text-2xl font-bold text-yellow-600">{{ $questionsPending }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-green-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pertanyaan Approved</span>
                            <span class="text-2xl font-bold text-green-600">{{ $questionsApproved }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-red-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Pertanyaan Rejected</span>
                            <span class="text-2xl font-bold text-red-600">{{ $questionsRejected }}</span>
                        </div>
                    </div>
                </div>

                <!-- Kartu Data FAQ -->
                <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Data FAQ</h2>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-blue-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">Total FAQ</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $totalFaqs }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-green-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">FAQ Published</span>
                            <span class="text-2xl font-bold text-green-600">{{ $faqsPublished }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg transition transform hover:scale-105">
                            <span class="text-gray-600">FAQ Draft</span>
                            <span class="text-2xl font-bold text-gray-600">{{ $faqsDraft }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
