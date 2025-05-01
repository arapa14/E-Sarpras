@extends('layouts.guest')

@section('content')

    <!-- Hero Section dengan Parallax & Overlay -->
    <section id="hero" class="relative h-screen flex items-center justify-center"
        style="background: url('{{ asset($img) }}') no-repeat center/cover;">
        <div class="absolute inset-0 bg-blue-900 opacity-60"></div>
        <div class="relative z-10 text-center text-white px-4" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-5xl md:text-6xl font-extrabold mb-6">Pengaduan Sarana Prasarana</h2>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">E-Sarpras memudahkan Anda melaporkan kerusakan,
                memantau perbaikan, dan mendapatkan informasi real-time dengan mudah.</p>
            <a href="{{ route('login') }}"
                class="inline-block px-10 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:bg-gray-100 transition">Mulai
                Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Keunggulan e-Sarpras</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div
                    class="flex flex-col items-center text-center p-6 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <svg class="w-16 h-16 text-blue-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-600">Antarmuka yang intuitif memudahkan setiap pengguna untuk mengakses
                        informasi dengan cepat.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="flex flex-col items-center text-center p-6 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <svg class="w-16 h-16 text-blue-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 1.343-3 3 0 1.306.835 2.417 2 2.83V18h2v-4.17c1.165-.413 2-1.524 2-2.83 0-1.657-1.343-3-3-3z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Real Time</h3>
                    <p class="text-gray-600">Pantau status dan laporan secara langsung dengan informasi yang selalu
                        terbarui.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="flex flex-col items-center text-center p-6 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <svg class="w-16 h-16 text-blue-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 15a4 4 0 004 4h10a4 4 0 004-4M3 15V9a4 4 0 014-4h10a4 4 0 014 4v6"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold mb-2">Transparan</h3>
                    <p class="text-gray-600">Meningkatkan akuntabilitas dengan pelaporan dan pemantauan yang
                        transparan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section dengan Accordion -->
    <section id="faq" class="py-16" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Frequently Asked Questions (FAQ)</h2>
            <div class="space-y-6">
                @forelse ($faqs->where('status', 'published') as $index => $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <button @click="open = !open"
                            class="w-full px-8 py-6 text-left flex items-center justify-between focus:outline-none">
                            <span class="text-2xl font-semibold text-blue-600">{{ $faq->question }}</span>
                            <svg x-show="!open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <svg x-show="open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse
                            class="px-8 pb-6 text-lg text-gray-600 border-t border-gray-200">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @empty
                    <!-- Tampilan ketika tidak ada pertanyaan -->
                    <div class="flex flex-col items-center justify-center bg-white rounded-2xl shadow p-10">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7 12a5 5 0 0110 0 5 5 0 01-10 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-xl">Belum ada pertanyaan yang diajukan.</p>
                        <p class="text-gray-400 mt-2">Silakan kirim pertanyaan Anda melalui form di bawah.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Timeline Tutorial Section -->
    <section id="tutorial" class="py-16 bg-gradient-to-br from-sky-50 via-gray-100 to-sky-200">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Cara Membuat Laporan</h2>

            <div class="space-y-10">
                <!-- Langkah 1 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            1
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Buat Akun</h3>
                        <p class="text-gray-600">Daftarkan diri Anda dan lengkapi data akun dengan benar.</p>
                    </div>
                </div>

                <!-- Langkah 2 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            2
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Login</h3>
                        <p class="text-gray-600">Masuk ke akun E-Sarpras Anda menggunakan email dan password.</p>
                    </div>
                </div>

                <!-- Langkah 3 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            3
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Pilih Menu Pengaduan</h3>
                        <p class="text-gray-600">Klik menu <span class="font-medium">"Buat Pengaduan"</span> di
                            dashboard Anda.</p>
                    </div>
                </div>

                <!-- Langkah 4 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            4
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Isi Form Laporan</h3>
                        <p class="text-gray-600">Lengkapi informasi pengaduan dengan jelas dan lengkap agar mudah
                            diproses.</p>
                    </div>
                </div>

                <!-- Langkah 5 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            5
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Kirim Laporan</h3>
                        <p class="text-gray-600">Tekan tombol <span class="font-medium">"Submit"</span> dan tunggu
                            konfirmasi dari admin.</p>
                    </div>
                </div>

                <!-- Langkah 6 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                            6
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Cek Riwayat</h3>
                        <p class="text-gray-600">Pantau status laporan Anda di menu <span class="font-medium">"Riwayat
                                Pengaduan"</span>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Pertanyaan Section -->
    <section id="pertanyaan" class="py-16" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Kirim Pertanyaan</h2>
            <div
                class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105 max-w-2xl mx-auto">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-6">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 text-red-800 p-4 rounded mb-6">{{ session('error') }}</div>
                @endif
                <!-- Tambahkan validasi onsubmit -->
                <form action="{{ route('question.store') }}" method="POST"
                    onsubmit="return validateAndSubmitQuestionForm()">
                    @csrf
                    <div class="mb-6">
                        <label for="question" class="block text-xl font-medium mb-2">Pertanyaan Anda</label>
                        <textarea name="question" id="question" rows="4"
                            class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Jika anda memiliki pertanyaan atau menemukan bug, silahkan tuliskan di sini"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-4 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition">
                        Kirim Pertanyaan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Scroll-to-Top Button -->
    <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">↑</button>

@endsection