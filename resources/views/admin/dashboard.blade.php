@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-4 md:p-8">
        <div class="container mx-auto max-w-7xl">
            <!-- Header dengan Background Gradient -->
            <header class="mb-8 py-8 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-3xl shadow-2xl text-center text-white backdrop-blur-sm relative overflow-hidden">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative z-10">
                    <h1 class="text-4xl font-bold mb-2 drop-shadow-lg">Dashboard Admin</h1>
                    <p class="text-lg opacity-90">Selamat datang, {{ Auth::user()->name }}</p>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
            </header>

            <!-- Data Pengaduan Section -->
            <div class="mb-12">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/25">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Data Pengaduan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Total Pengaduan -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ $totalComplaints }}</div>
                                <div class="text-gray-600 font-medium">Total Pengaduan</div>
                                <div class="flex items-center text-sm text-blue-500 font-medium">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                                    Semua data
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">{{ $complaintsPending }}</div>
                                <div class="text-gray-600 font-medium">Pending</div>
                                <div class="flex items-center text-sm text-yellow-600 font-medium">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                    Menunggu
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- On Progress -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-red-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-orange-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">{{ $complaintsProgress }}</div>
                                <div class="text-gray-600 font-medium">On Progress</div>
                                <div class="flex items-center text-sm text-orange-600 font-medium">
                                    <div class="w-2 h-2 bg-orange-400 rounded-full mr-2 animate-pulse"></div>
                                    Proses
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">{{ $complaintsCompleted }}</div>
                                <div class="text-gray-600 font-medium">Selesai</div>
                                <div class="flex items-center text-sm text-green-600 font-medium">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                    Selesai
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pertanyaan Section -->
            <div class="mb-12">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-purple-500/25">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Data Pertanyaan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Total Pertanyaan -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">{{ $totalQuestions }}</div>
                                <div class="text-gray-600 font-medium">Total Pertanyaan</div>
                                <div class="flex items-center text-sm text-blue-500 font-medium">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                                    Total
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">{{ $questionsPending }}</div>
                                <div class="text-gray-600 font-medium">Pending</div>
                                <div class="flex items-center text-sm text-yellow-600 font-medium">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                    Review
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approved -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">{{ $questionsApproved }}</div>
                                <div class="text-gray-600 font-medium">Approved</div>
                                <div class="flex items-center text-sm text-green-600 font-medium">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                    Disetujui
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-red-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">{{ $questionsRejected }}</div>
                                <div class="text-gray-600 font-medium">Rejected</div>
                                <div class="flex items-center text-sm text-red-600 font-medium">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></div>
                                    Ditolak
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data FAQ Section -->
            <div class="mb-12">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-500/25">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Data FAQ</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Total FAQ -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $totalFaqs }}</div>
                                <div class="text-gray-600 font-medium">Total FAQ</div>
                            </div>
                        </div>
                    </div>

                    <!-- Published -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-green-600 to-emerald-700 bg-clip-text text-transparent">{{ $faqsPublished }}</div>
                                <div class="text-gray-600 font-medium">Published</div>
                            </div>
                        </div>
                    </div>

                    <!-- Draft -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-400 to-slate-500 rounded-3xl opacity-0 group-hover:opacity-100 transition-all duration-500 blur-xl group-hover:blur-2xl"></div>
                        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-slate-500 rounded-2xl flex items-center justify-center shadow-lg shadow-gray-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 bg-gray-400 rounded-full animate-pulse"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="text-4xl font-black bg-gradient-to-r from-gray-600 to-slate-600 bg-clip-text text-transparent">{{ $faqsDraft }}</div>
                                <div class="text-gray-600 font-medium">Draft</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection