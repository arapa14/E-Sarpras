@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-4">
        <div class="container mx-auto max-w-7xl">
            <!-- Header dengan animasi dan glassmorphism effect -->
            <header class="relative overflow-hidden bg-white/70 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-xl mb-8">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 via-purple-600/20 to-pink-600/20"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                    Dashboard Super Admin
                                </h1>
                                <p class="text-gray-600 mt-1">
                                    Selamat datang, <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <div class="flex items-center space-x-2 bg-white/50 rounded-full px-4 py-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-sm text-gray-600">Online</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Pantau data analitik sistem dengan mudah di perangkat mobile Anda!
                    </p>
                </div>
            </header>

            <!-- Section Cards dengan hover effects -->
            <section class="space-y-8">
                <!-- Data Pengaduan -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            Data Pengaduan
                        </h2>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Real-time</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-blue-700">Total Pengaduan</p>
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">T</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalComplaints }}</p>
                            <p class="text-xs text-blue-500 mt-1">↗ Semua data</p>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-yellow-700">Pending</p>
                                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">P</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-yellow-600">{{ $complaintsPending }}</p>
                            <p class="text-xs text-yellow-500 mt-1">⏳ Menunggu</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-orange-700">On Progress</p>
                                <div class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">O</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-orange-600">{{ $complaintsProgress }}</p>
                            <p class="text-xs text-orange-500 mt-1">🔄 Proses</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-green-700">Selesai</p>
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">✓</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-green-600">{{ $complaintsCompleted }}</p>
                            <p class="text-xs text-green-500 mt-1">✅ Selesai</p>
                        </div>
                    </div>
                </div>

                <!-- Data Pertanyaan -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Data Pertanyaan
                        </h2>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Q&A</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-blue-700">Total Pertanyaan</p>
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">?</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalQuestions }}</p>
                            <p class="text-xs text-blue-500 mt-1">📝 Total</p>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-yellow-700">Pending</p>
                                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">⏳</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-yellow-600">{{ $questionsPending }}</p>
                            <p class="text-xs text-yellow-500 mt-1">⏳ Review</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-green-700">Approved</p>
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">✓</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-green-600">{{ $questionsApproved }}</p>
                            <p class="text-xs text-green-500 mt-1">✅ Disetujui</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-red-700">Rejected</p>
                                <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">✕</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-red-600">{{ $questionsRejected }}</p>
                            <p class="text-xs text-red-500 mt-1">❌ Ditolak</p>
                        </div>
                    </div>
                </div>

                <!-- Data FAQ -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            Data FAQ
                        </h2>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Knowledge Base</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-blue-700">Total FAQ</p>
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">📚</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalFaqs }}</p>
                            <p class="text-xs text-blue-500 mt-1">📋 Semua FAQ</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-green-700">Published</p>
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">🌐</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-green-600">{{ $faqsPublished }}</p>
                            <p class="text-xs text-green-500 mt-1">🌐 Dipublikasi</p>
                        </div>
                        <div class="col-span-2 lg:col-span-1 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-gray-700">Draft</p>
                                <div class="w-6 h-6 bg-gray-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">📝</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-gray-600">{{ $faqsDraft }}</p>
                            <p class="text-xs text-gray-500 mt-1">✏️ Draft</p>
                        </div>
                    </div>
                </div>

                <!-- Data Sistem & Pengguna -->
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            Data Sistem & Pengguna
                        </h2>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">System</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-indigo-700">Total Pengguna</p>
                                <div class="w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">👥</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                            <p class="text-xs text-indigo-500 mt-1">👤 Registered</p>
                        </div>
                        <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-teal-700">Pengaturan</p>
                                <div class="w-6 h-6 bg-teal-500 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-white font-bold">⚙️</span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-teal-600">{{ $totalSettings }}</p>
                            <p class="text-xs text-teal-500 mt-1">⚙️ Konfigurasi</p>
                        </div>
                    </div>
                </div>

                <!-- Data Lokasi (jika ada) -->
                @if (!empty($locations) && count($locations) > 0)
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border border-white/50">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                Data Lokasi
                            </h2>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Locations</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($locations as $index => $location)
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs font-medium text-purple-700">Lokasi {{ $index + 1 }}</p>
                                        <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                            <span class="text-xs text-white font-bold">📍</span>
                                        </div>
                                    </div>
                                    <p class="text-lg font-bold text-purple-600 truncate">{{ $location->location }}</p>
                                    <p class="text-xs text-purple-500 mt-1">🌍 {{ $location->location }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>

            <!-- Footer dengan info tambahan -->
            <footer class="mt-12 text-center">
                <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <p class="text-xs text-gray-500">
                        Last updated: {{ now()->format('d M Y, H:i') }} WIB
                    </p>
                </div>
            </footer>
        </div>
    </div>
@endsection