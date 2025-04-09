@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-100 p-4">
        <div class="container mx-auto">
            <!-- Header -->
            <header class="bg-gradient-to-r from-indigo-500 to-purple-500 p-6 rounded-lg shadow text-white text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Dashboard Super Admin</h1>
                <p class="text-sm sm:text-base">
                    Selamat datang, {{ Auth::user()->name }}. Pantau data analitik sistem dengan mudah di perangkat mobile
                    Anda!
                </p>
            </header>

            <!-- Section Cards -->
            <section class="space-y-6">
                <!-- Data Pengaduan -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pengaduan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Total Pengaduan</p>
                            <p class="text-xl font-bold text-blue-600">{{ $totalComplaints }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Pending</p>
                            <p class="text-xl font-bold text-yellow-600">{{ $complaintsPending }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">On Progress</p>
                            <p class="text-xl font-bold text-orange-600">{{ $complaintsProgress }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Selesai</p>
                            <p class="text-xl font-bold text-green-600">{{ $complaintsCompleted }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Pertanyaan -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pertanyaan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Total Pertanyaan</p>
                            <p class="text-xl font-bold text-blue-600">{{ $totalQuestions }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Pending</p>
                            <p class="text-xl font-bold text-yellow-600">{{ $questionsPending }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Approved</p>
                            <p class="text-xl font-bold text-green-600">{{ $questionsApproved }}</p>
                        </div>
                        <div class="bg-red-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Rejected</p>
                            <p class="text-xl font-bold text-red-600">{{ $questionsRejected }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data FAQ -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data FAQ</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Total FAQ</p>
                            <p class="text-xl font-bold text-blue-600">{{ $totalFaqs }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Published</p>
                            <p class="text-xl font-bold text-green-600">{{ $faqsPublished }}</p>
                        </div>
                        <div class="col-span-2 bg-gray-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Draft</p>
                            <p class="text-xl font-bold text-gray-600">{{ $faqsDraft }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Sistem & Pengguna -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Sistem & Pengguna</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-indigo-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Total Pengguna</p>
                            <p class="text-xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-teal-100 rounded-lg p-3 flex flex-col items-center">
                            <p class="text-xs text-gray-600">Pengaturan</p>
                            <p class="text-xl font-bold text-teal-600">{{ $totalSettings }}</p>
                        </div>
                    </div>
                </div>

                <!-- Data Lokasi (jika ada) -->
                @if (!empty($locations) && count($locations) > 0)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Lokasi</h2>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ($locations as $location)
                                <div class="bg-purple-100 rounded-lg p-3 flex flex-col items-center">
                                    <p class="text-xs text-gray-600">Lokasi</p>
                                    <p class="text-xl font-bold text-purple-600">{{ $location->location }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
