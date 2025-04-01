<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $apk ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo ?? 'default-logo.png') }}" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        /* Sidebar dengan gradasi dan styling yang lebih modern */
        .sidebar {
            background: linear-gradient(to bottom right, #1e3a8a, #1e40af);
        }

        .sidebar a {
            color: #e0e7ff;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .sidebar a i {
            transition: transform 0.3s ease;
        }

        .sidebar a:hover i {
            transform: translateX(5px);
        }

        /* Logo dan nama aplikasi pada sidebar */
        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #facc15;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <!-- Header khusus untuk Mobile -->
        <header class="bg-white shadow p-4 sm:hidden">
            <div class="flex items-center justify-between">
                <!-- Tombol Toggle Sidebar -->
                <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
                    <i class="fas fa-bars fa-2x"></i>
                </button>
                <!-- Tampilan Jam dengan styling lebih besar dan tegas -->
                <span id="realTimeClock" class="text-gray-700 font-semibold text-lg">Memuat Waktu...</span>
                <!-- Placeholder untuk menjaga posisi tengah -->
                <div class="w-8"></div>
            </div>
        </header>

        <!-- Header untuk Desktop -->
        <header class="bg-white shadow p-4 hidden sm:flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset($logo ?? 'default-logo.png') }}" alt="Logo" class="w-12 h-12 object-cover">
                <h1 class="text-xl font-bold text-blue-600">Selamat datang, {{ auth()->user()->name ?? 'User' }}</h1>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('logout') }}" method="POST" class="flex items-center">
                    @csrf
                    <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 17l5-5-5-5M21 12H9m4-7v14"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Container -->
        <div class="flex flex-1 relative">
            <!-- Sidebar -->
            <nav id="sidebar"
                class="sidebar p-4 w-64 fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 z-20 sm:relative sm:translate-x-0">
                <!-- Logo & App Name (hanya muncul pada tampilan mobile) -->
                <div class="sm:hidden flex flex-col items-center border-b border-yellow-500 pb-4 mb-4">
                    <div class="relative flex flex-col items-center justify-center">
                        <div class="w-12 h-12 mb-2 relative">
                            <img src="{{ $logo }}" alt="{{ $apk }}"
                                class="w-full h-full object-cover rounded-full border border-white shadow-md transform hover:scale-110 transition duration-300 ease-in-out">
                        </div>
                        <h2 class="logo tracking-wide drop-shadow">
                            {{ $apk }}
                        </h2>
                    </div>
                </div>

                <!-- Sidebar Navigation Links -->
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-3 rounded hover:bg-white hover:bg-opacity-20 transition-colors duration-300 {{ request()->is('dashboard') ? 'active bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('complaint.index') }}"
                            class="flex items-center p-3 rounded hover:bg-white hover:bg-opacity-20 transition-colors duration-300 {{ request()->is('pengaduan') ? 'active bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-comment-alt mr-3"></i> Buat Pengaduan
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"
                            class="flex items-center p-3 rounded hover:bg-white hover:bg-opacity-20 transition-colors duration-300 {{ request()->is('history') ? 'active bg-white bg-opacity-20' : '' }}">
                            <i class="fas fa-history mr-3"></i> Riwayat Pengaduan
                        </a>
                    </li>
                    <!-- Tombol Logout (hanya tampil di mobile) -->
                    <li class="sm:hidden">
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

            <!-- Overlay Sidebar untuk mobile -->
            <div id="sidebarOverlay" class="fixed inset-0 bg-black opacity-50 hidden z-10 sm:hidden"></div>

            <!-- Konten Dinamis -->
            <main class="flex-1 p-6 ml-0 sm:ml-6 transition-all duration-300">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-200 text-center p-4">
            &copy; {{ date('Y') }} SMKN 1 Jakarta. All rights reserved.
        </footer>
    </div>

    <!-- Script -->
    <script>
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
</body>

</html>
