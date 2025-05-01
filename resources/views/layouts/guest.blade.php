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

        /* Animasi untuk spinner */
        #loadingOverlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background-color: rgba(0, 0, 0, 0.5);
        }

        #loadingOverlay .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased transition-colors duration-300">
    <!-- Overlay Spinner -->
    <div id="loadingOverlay">
        <div class="spinner">
            <svg class="animate-spin h-12 w-12 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    </div>

    <!-- Navbar -->
    <header x-data="{ open: false }" class="sticky top-0 z-50 backdrop-blur-md shadow"
        style="background-color: rgba(255, 255, 255, 0.7);">
        <!-- Konten header -->
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset($logo) }}" alt="Logo e-Sarpras"
                    class="w-12 h-12 object-contain transition-transform duration-300 hover:scale-110" />
                <h1 class="text-2xl font-bold text-blue-600">{{ $name }}</h1>
            </div>
            <nav class="hidden md:flex space-x-8">
                <a href="{{ Request::routeIs('anonim.index') ? url('/') : '#hero' }}"
                    class="text-gray-600 hover:text-blue-600 transition">Home</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#features' : '#features' }}"
                    class="text-gray-600 hover:text-blue-600 transition">Keunggulan</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#faq' : '#faq' }}"
                    class="text-gray-600 hover:text-blue-600 transition">FAQ</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#tutorial' : '#tutorial' }}"
                    class="text-gray-600 hover:text-blue-600 transition">Tutorial</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#pertanyaan' : '#pertanyaan' }}"
                    class="text-gray-600 hover:text-blue-600 transition">Pertanyaan</a>
                <a href="{{ route('anonim.index') }}" class="text-gray-600 hover:text-blue-600 transition">Anonim</a>
            </nav>

            <div class="hidden md:block">
                <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-blue-600 text-white rounded-full shadow hover:bg-blue-700 transition">Login</a>
            </div>
            <div class="md:hidden">
                <button @click="open = !open" class="focus:outline-none" aria-label="Toggle Menu">
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
                <a href="{{ Request::routeIs('anonim.index') ? url('/') : '#hero' }}"
                    class="block text-gray-600 hover:text-blue-600 transition">Home</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#features' : '#features' }}"
                    class="block text-gray-600 hover:text-blue-600 transition">Keunggulan</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#faq' : '#faq' }}"
                    class="block text-gray-600 hover:text-blue-600 transition">FAQ</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#tutorial' : '#tutorial' }}"
                    class="block text-gray-600 hover:text-blue-600 transition">Tutorial</a>
                <a href="{{ Request::routeIs('anonim.index') ? url('/') . '#pertanyaan' : '#pertanyaan' }}"
                    class="block text-gray-600 hover:text-blue-600 transition">Pertanyaan</a>
                <a href="{{ route('anonim.index') }}"
                    class="block text-gray-600 hover:text-blue-600 transition">Anonim</a>
                <a href="{{ route('login') }}"
                    class="block mt-2 px-6 py-2 bg-blue-600 text-white rounded-full text-center shadow hover:bg-blue-700 transition">Login</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300">
        <div class="container mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row md:justify-between">
                <div class="mb-8 md:mb-0">
                    <h3 class="text-2xl font-bold text-white">{{ $name }}</h3>
                    <p class="mt-2 text-gray-400">
                        Sistem Informasi Pengaduan Sarana Prasarana yang memudahkan Anda untuk melaporkan kerusakan dan
                        memantau perbaikan dengan mudah.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-xl font-semibold text-white mb-4">Informasi</h4>
                        <ul>
                            <li class="mb-2">
                                <a href="https://smkn1jakarta.sch.id/" class="hover:text-white transition"
                                    target="_blank" rel="noopener noreferrer">
                                    smkn1jakarta.sch.id
                                </a>
                            </li>
                            <!-- Tambahkan tautan lain jika diperlukan -->
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xl font-semibold text-white mb-4">Navigasi</h4>
                        <ul>
                            <li class="mb-2"><a href="#hero" class="hover:text-white transition">Home</a></li>
                            <li class="mb-2"><a href="#features" class="hover:text-white transition">Keunggulan</a>
                            </li>
                            <li class="mb-2"><a href="#faq" class="hover:text-white transition">FAQ</a></li>
                            <li class="mb-2"><a href="#tutorial" class="hover:text-white transition">Tutorial</a>
                            </li>
                            <li class="mb-2"><a href="#pertanyaan"
                                    class="hover:text-white transition">Pertanyaan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-6 text-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SMKN 1 Jakarta. All rights reserved.</p>
                <div class="flex justify-center space-x-4 mt-4">
                    <a href="https://youtube.com/@smkn1jakartaofficial?si=beOC0W-ArQKBjdLc"
                        class="text-gray-400 hover:text-white transition" target="_blank" rel="noopener noreferrer"
                        title="YouTube">
                        <!-- Ikon YouTube -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a2.993 2.993 0 00-2.106-2.117C19.752 3.5 12 3.5 12 3.5s-7.752 0-9.392.569A2.993 2.993 0 00.502 6.186 31.94 31.94 0 000 12a31.94 31.94 0 00.502 5.814 2.993 2.993 0 002.106 2.117C4.248 20.5 12 20.5 12 20.5s7.752 0 9.392-.569a2.993 2.993 0 002.106-2.117A31.94 31.94 0 0024 12a31.94 31.94 0 00-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/smkn1jakarta_official?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        class="text-gray-400 hover:text-white transition" target="_blank" rel="noopener noreferrer"
                        title="Instagram">
                        <!-- Ikon Instagram -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12,2.16c3.2,0,3.584,0.012,4.85,0.07,1.17,0.054,1.96,0.24,2.42,0.402a4.84,4.84,0,0,1,1.75,1.012,4.84,4.84,0,0,1,1.012,1.75c0.163,0.46,0.348,1.25,0.402,2.42,0.058,1.266,0.07,1.65,0.07,4.85s-0.012,3.584-0.07,4.85c-0.054,1.17-0.24,1.96-0.402,2.42a4.84,4.84,0,0,1-1.012,1.75,4.84,4.84,0,0,1-1.75,1.012c-0.46,0.163-1.25,0.348-2.42,0.402-1.266,0.058-1.65,0.07-4.85,0.07s-3.584-0.012-4.85-0.07c-1.17-0.054-1.96-0.24-2.42-0.402a4.84,4.84,0,0,1-1.75-1.012,4.84,4.84,0,0,1-1.012-1.75c-0.163-0.46-0.348-1.25-0.402-2.42C2.172,15.744,2.16,15.36,2.16,12S2.172,8.416,2.23,7.15c0.054-1.17,0.24-1.96,0.402-2.42A4.84,4.84,0,0,1,3.644,2.98a4.84,4.84,0,0,1,1.75-1.012c0.46-0.163,1.25-0.348,2.42-0.402C8.416,2.172,8.8,2.16,12,2.16 M12,0C8.741,0,8.332,0.014,7.052,0.072,5.775,0.13,4.671,0.324,3.757,0.632a7.02,7.02,0,0,0-2.55,1.663A7.02,7.02,0,0,0,0.632,4.757C0.324,5.671,0.13,6.775,0.072,8.052,0.014,9.332,0,9.741,0,12s0.014,2.668,0.072,3.948c0.058,1.277,0.252,2.381,0.56,3.295a7.02,7.02,0,0,0,1.663,2.55,7.02,7.02,0,0,0,2.55,1.663c0.914,0.308,2.018,0.502,3.295,0.56C9.332,23.986,9.741,24,12,24s2.668-0.014,3.948-0.072c1.277-0.058,2.381-0.252,3.295-0.56a7.02,7.02,0,0,0,2.55-1.663,7.02,7.02,0,0,0,1.663-2.55c0.308-0.914,0.502-2.018,0.56-3.295C23.986,14.668,24,14.259,24,12s-0.014-2.668-0.072-3.948c-0.058-1.277-0.252-2.381-0.56-3.295a7.02,7.02,0,0,0-1.663-2.55A7.02,7.02,0,0,0,20.243,0.632c-0.914-0.308-2.018-0.502-3.295-0.56C14.668,0.014,14.259,0,12,0L12,0z" />
                        </svg>
                    </a>
                </div>
            </div>
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

        // Fungsi menampilkan spinner
        function showSpinner() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }

        // Fungsi validasi sebelum submit form pertanyaan
        function validateAndSubmitQuestionForm() {
            var question = document.getElementById("question").value.trim();
            if (question === "") {
                toastr.error("Tulis pertanyaan terlebih dahulu");
                return false; // Batalkan submit form
            }
            showSpinner(); // Tampilkan loading spinner jika valid
            return true;
        }
    </script>
    @yield('scripts')
</body>

</html>
