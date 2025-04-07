<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $apk ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo ?? 'default-logo.png') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <!-- Sertakan CSS Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .sidebar {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
        }

        .sidebar a {
            color: #e0e7ff;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .sidebar a i {
            transition: transform 0.3s ease;
        }

        .sidebar a:hover i {
            transform: translateX(5px);
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
    @yield('styles')
</head>

<body class="bg-gray-50 font-sans">
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

    <div class="min-h-screen flex flex-col">
        <!-- Header khusus untuk Mobile (fixed dan transparan) -->
        <header class="fixed top-0 inset-x-0 z-40 bg-gradient-to-r from-blue-600 to-blue-800 shadow-md p-4 sm:hidden">
            <div class="flex items-center justify-between">
                <button id="sidebarToggle" class="text-white focus:outline-none">
                    <i class="fas fa-bars fa-2x"></i>
                </button>
                <span id="realTimeClock" class="text-white font-semibold text-lg">Memuat Waktu...</span>
                <div class="w-8"></div>
            </div>
        </header>

        <!-- Catatan: Header untuk Desktop dihilangkan sesuai instruksi -->

        <!-- Kontainer Utama -->
        <div class="flex flex-1 relative pt-16 sm:pt-0">
            <!-- Sidebar (selalu tampil logo, nama & role) -->
            <nav id="sidebar"
                class="sidebar p-4 w-64 fixed inset-y-0 left-0 z-[30] transform -translate-x-full transition-transform duration-300 sm:relative sm:translate-x-0 sm:sticky sm:top-0 h-screen overflow-y-auto bg-gray-800">
                <!-- Logo, Nama Aplikasi & Role (selalu tampil) -->
                <div class="flex flex-col items-center pb-2 mb-4">
                    <div class="w-16 h-16 mb-2">
                        <img src="{{ asset($logo ?? 'default-logo.png') }}" alt="{{ $apk }}"
                            class="w-full h-full object-cover rounded-full border-2 border-white shadow-lg transform hover:scale-110 transition duration-300">
                    </div>
                    <h2 class="logo text-xl font-semibold tracking-wide text-yellow-400 drop-shadow">
                        {{ $apk }}
                    </h2>
                    <!-- Divider -->
                    <div class="w-full border-b border-yellow-500 my-2"></div>
                    @if (auth()->user()->name)
                        <p class="text-white font-medium mt-2">{{ auth()->user()->name ?? 'User' }}</p>
                        <span class="text-sm text-yellow-300">{{ ucfirst(auth()->user()->role) }}</span>
                        <!-- Divider -->
                        <div class="w-full border-b pt-2 border-yellow-500 my-2"></div>
                    @endif
                </div>

                <!-- Navigasi Sidebar -->
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('complaint.list') }}"
                            class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('complaint') ? 'active' : '' }}">
                            <i class="fas fa-comment-alt mr-3"></i> Pengaduan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq.index') }}"
                            class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('faq') ? 'active' : '' }}">
                            <i class="fas fa-history mr-3"></i> Frequently Asked Questions (FAQ)
                        </a>
                    </li>

                    @if (auth()->user()->role == 'superAdmin')
                        <li>
                            <a href="{{ route('user.index') }}"
                                class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('user') ? 'active' : '' }}">
                                <i class="fas fa-users mr-3"></i> Pengguna
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('location.index') }}"
                                class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('location') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt mr-3"></i> Lokasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('setting.index') }}"
                                class="flex items-center p-3 rounded transition-colors duration-300 {{ request()->is('setting') ? 'active' : '' }}">
                                <i class="fas fa-cogs mr-3"></i> Pengaturan
                            </a>
                        </li>,
                    @endif

                    <!-- Tombol Logout khusus untuk Mobile -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors duration-300">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Overlay untuk Sidebar pada tampilan mobile -->
            <div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 hidden z-10 sm:hidden"></div>

            <!-- Konten Utama (digeser ke kanan di desktop agar tidak tertutup sidebar) -->
            <main class="flex-1 p-6 ml-0 mt-5 pb-15 transition-all duration-300">
                @yield('content')
            </main>
        </div>

        <!-- Catatan: Footer dihilangkan untuk mobile dan desktop sesuai instruksi -->
    </div>

    @if (session()->has('original_user_id'))
        <div id="impersonationBanner"
            class="fixed top-4 right-4 z-50 bg-white opacity-70 border border-gray-300 rounded-lg shadow-lg p-4 max-w-xs">
            <div class="flex items-center justify-between">
                <h5 class="text-sm font-bold text-gray-800">Impersonasi Aktif</h5>
                <a href="{{ route('user.switch.back') }}"
                    class="text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded px-2 py-1">
                    Kembali
                </a>
            </div>
            <p class="mt-2 text-xs text-gray-700">
                Anda sedang login sebagai <strong>{{ auth()->user()->name }}</strong>
                (<em>{{ auth()->user()->email }}</em>).
            </p>
        </div>
    @endif

    <!-- Script -->
    <script>
        // Fungsi menampilkan spinner
        function showSpinner() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }

        // Tampilkan spinner saat berpindah halaman
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll("a");
            links.forEach(link => {
                link.addEventListener("click", function(event) {
                    if (link.getAttribute("target") !== "_blank" && link.getAttribute("href") !==
                        "#") {
                        document.getElementById("loadingOverlay").style.display = "block";
                    }
                });
            });

            // Sembunyikan spinner setelah halaman dimuat
            window.addEventListener("load", function() {
                document.getElementById("loadingOverlay").style.display = "none";
            });
        });

        // Fungsi update waktu real-time
        function updateClock() {
            const now = new Date();
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            document.getElementById('realTimeClock').innerText =
                `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes}`;
        }
        updateClock();
        setInterval(updateClock, 30000);

        // Toggle Sidebar untuk mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    </script>

    <!-- Sertakan jQuery dan Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    @yield('scripts')
</body>

</html>
