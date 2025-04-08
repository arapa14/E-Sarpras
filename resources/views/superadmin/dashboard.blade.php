@extends('layouts.admin')
{{-- Asumsikan layout admin bisa dipakai untuk super admin juga, 
     atau anda bisa membuat layout baru sesuai kebutuhan --}}

@section('content')
    <div class="min-h-screen bg-gray-50 p-6 md:p-10">
        <div class="container mx-auto">
            <!-- Header dengan Background Gradient -->
            <header
                class="mb-10 py-10 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-lg shadow-lg text-center text-white">
                <h1 class="text-4xl font-extrabold mb-3">Dashboard Super Admin</h1>
                <p class="text-lg">Selamat datang, {{ Auth::user()->name }}. Berikut data analitik keseluruhan sistem.</p>
            </header>

            <!-- Grid Utama -->
            <div class="grid grid-cols-1 gap-8">
                <!-- Baris 1: Data Pengaduan -->
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Data Pengaduan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Total Pengaduan</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalComplaints }}</p>
                        </div>
                        <div class="p-6 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pengaduan Pending</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $complaintsPending }}</p>
                        </div>
                        <div class="p-6 bg-orange-50 rounded-lg hover:bg-orange-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pengaduan On Progress</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $complaintsProgress }}</p>
                        </div>
                        <div class="p-6 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pengaduan Selesai</p>
                            <p class="text-3xl font-bold text-green-600">{{ $complaintsCompleted }}</p>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Data Pertanyaan -->
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Data Pertanyaan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Total Pertanyaan</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalQuestions }}</p>
                        </div>
                        <div class="p-6 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pertanyaan Pending</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $questionsPending }}</p>
                        </div>
                        <div class="p-6 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pertanyaan Approved</p>
                            <p class="text-3xl font-bold text-green-600">{{ $questionsApproved }}</p>
                        </div>
                        <div class="p-6 bg-red-50 rounded-lg hover:bg-red-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Pertanyaan Rejected</p>
                            <p class="text-3xl font-bold text-red-600">{{ $questionsRejected }}</p>
                        </div>
                    </div>
                </div>

                <!-- Baris 3: Data FAQ -->
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Data FAQ</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Total FAQ</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalFaqs }}</p>
                        </div>
                        <div class="p-6 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                            <p class="text-gray-600 font-medium">FAQ Published</p>
                            <p class="text-3xl font-bold text-green-600">{{ $faqsPublished }}</p>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                            <p class="text-gray-600 font-medium">FAQ Draft</p>
                            <p class="text-3xl font-bold text-gray-600">{{ $faqsDraft }}</p>
                        </div>
                    </div>
                </div>

                <!-- Baris 4: Data User & Settings -->
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Data Sistem & Pengguna</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Total User -->
                        <div class="p-6 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Total Pengguna</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                        </div>
                        <!-- Total Settings -->
                        <div class="p-6 bg-teal-50 rounded-lg hover:bg-teal-100 transition duration-200">
                            <p class="text-gray-600 font-medium">Total Pengaturan</p>
                            <p class="text-3xl font-bold text-teal-600">{{ $totalSettings }}</p>
                        </div>
                    </div>
                </div>

                <!-- Baris 5: Data Lokasi (jika diperlukan) -->
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition duration-300 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Data Lokasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($locations as $location)
                            <div class="p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                                <p class="text-gray-600 font-medium">Lokasi</p>
                                <p class="text-xl font-bold text-purple-600">{{ $location->location }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
