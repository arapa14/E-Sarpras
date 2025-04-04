<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $name }}</title>
    <link rel="icon" href="{{ asset($logo) }}" type="image/png" />
    @vite('resources/css/app.css')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Alpine.js untuk interaktivitas -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- AOS (Animate On Scroll) Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animasi Fade In */
        .fade-in {
            animation: fadeIn 0.8s ease-in forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scroll-to-Top Button */
        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 100;
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 9999px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        #scrollTopBtn:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased transition-colors duration-300">
    <!-- Navbar -->
    <header x-data="{ open: false }"
        class="fixed top-0 left-0 right-0 z-50 bg-white bg-opacity-95 backdrop-blur-md shadow">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset($logo) }}" alt="Logo e-Sarpras"
                    class="w-12 h-12 object-contain transition-transform duration-300 hover:scale-110" />
                <h1 class="text-2xl font-bold text-blue-600">{{ $name }}</h1>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="#hero" class="text-gray-600 hover:text-blue-600 transition">Home</a>
                <a href="#features" class="text-gray-600 hover:text-blue-600 transition">Keunggulan</a>
                <a href="#faq" class="text-gray-600 hover:text-blue-600 transition">FAQ</a>
                <a href="#tutorial" class="text-gray-600 hover:text-blue-600 transition">Tutorial</a>
                <a href="#pertanyaan" class="text-gray-600 hover:text-blue-600 transition">Pertanyaan</a>
            </nav>
            <div class="hidden md:block">
                <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700 transition">Login</a>
            </div>
            <div class="md:hidden">
                <button @click="open = !open" class="focus:outline-none">
                    <svg x-show="!open" class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="open" class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="open" @click.away="open = false" class="md:hidden">
            <nav class="px-6 pt-2 pb-4 space-y-2 bg-white shadow">
                <a href="#hero" class="block text-gray-600 hover:text-blue-600 transition">Home</a>
                <a href="#features" class="block text-gray-600 hover:text-blue-600 transition">Keunggulan</a>
                <a href="#faq" class="block text-gray-600 hover:text-blue-600 transition">FAQ</a>
                <a href="#tutorial" class="block text-gray-600 hover:text-blue-600 transition">Tutorial</a>
                <a href="#pertanyaan" class="block text-gray-600 hover:text-blue-600 transition">Pertanyaan</a>
                <a href="{{ route('login') }}"
                    class="block mt-2 px-6 py-2 bg-blue-600 text-white rounded-full text-center shadow hover:bg-blue-700 transition">Login</a>
            </nav>
        </div>
    </header>

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
                    <svg class="w-16 h-16 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
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
            <h2 class="text-4xl font-bold text-center mb-12">Pertanyaan Umum</h2>
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
                    <p class="text-center text-gray-500">Tidak ada pertanyaan yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section id="tutorial" class="py-16 bg-gray-100" data-aos="fade-up" data-aos-duration="1000">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">Cara Membuat Laporan</h2>
            <div
                class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105 max-w-3xl mx-auto">
                <ol class="list-decimal list-inside space-y-4 text-xl text-gray-600">
                    <li>Login ke akun e-Sarpras Anda.</li>
                    <li>Pilih menu "Buat Laporan".</li>
                    <li>Isi form laporan dengan informasi yang diperlukan.</li>
                    <li>Submit laporan dan tunggu konfirmasi dari admin.</li>
                </ol>
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
                <form action="{{ route('question.store') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="question" class="block text-xl font-medium mb-2">Pertanyaan Anda</label>
                        <textarea name="question" id="question" rows="4"
                            class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Tulis pertanyaan Anda di sini..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-4 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition">Kirim
                        Pertanyaan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Scroll-to-Top Button -->
    <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">↑</button>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="container mx-auto px-6 py-8 text-center">
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SMKN 1 Jakarta. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery dan Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init();

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Tampilkan tombol scroll-to-top saat scroll
        window.onscroll = function() {
            document.getElementById('scrollTopBtn').style.display = (document.body.scrollTop > 200 || document
                .documentElement.scrollTop > 200) ? 'block' : 'none';
        };
    </script>
</body>

</html>
