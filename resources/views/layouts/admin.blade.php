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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
/* Replace the existing sidebar styles in admin.blade.php with these: */

.sidebar {
    background: linear-gradient(145deg, #0f172a, #1e293b, #334155);
    backdrop-filter: blur(16px);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

.sidebar-header {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.15));
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    padding: 20px;
    margin: 16px;
    text-align: center;
}

.nav-item {
    position: relative;
    color: #cbd5e1;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
    border: 1px solid transparent;
    background: rgba(255, 255, 255, 0.02);
    margin: 8px 16px;
}

.nav-item:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(147, 51, 234, 0.1));
    border-color: rgba(59, 130, 246, 0.3);
    color: #f1f5f9;
    transform: translateX(4px);
    box-shadow: 
        0 4px 15px rgba(59, 130, 246, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.nav-item.active {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.2);
    box-shadow: 
        0 8px 25px rgba(59, 130, 246, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.nav-item i {
    transition: all 0.3s ease;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

.nav-item:hover i {
    transform: scale(1.1);
}

.nav-item.active i {
    transform: scale(1.1);
}

.badge {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.logo-container {
    position: relative;
    margin-bottom: 16px;
}

.logo-container::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(45deg, #3b82f6, #8b5cf6, #3b82f6);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.logo-container:hover::before {
    opacity: 1;
    animation: rotate 3s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.divider {
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    height: 1px;
    margin: 16px 0;
}

/* Mobile Header Enhancement */
.mobile-header {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.mobile-toggle-btn {
    position: relative;
    transition: all 0.3s ease;
}

.mobile-toggle-btn:hover {
    transform: scale(1.05);
}

.mobile-toggle-btn:active {
    transform: scale(0.95);
}

/* Loading Overlay */
#loadingOverlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(30, 41, 59, 0.9));
    backdrop-filter: blur(4px);
}

#loadingOverlay .spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* FIXED: Responsive Layout */
.app-container {
    display: flex;
    min-height: 100vh;
    min-height: 100dvh; /* Dynamic viewport height for mobile */
}

/* FIXED: Mobile Styles */
@media (max-width: 639px) {
    .mobile-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
        padding: 16px;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        height: 100dvh; /* Dynamic viewport height */
        z-index: 40;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 30;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .main-content {
        flex: 1;
        padding-top: 80px; /* Account for mobile header */
        padding-left: 0;
        padding-right: 0;
        min-height: calc(100vh - 80px);
        min-height: calc(100dvh - 80px); /* Dynamic viewport height */
    }
}

/* FIXED: Tablet and Desktop Styles */
@media (min-width: 640px) {
    .mobile-header {
        display: none;
    }

    .sidebar {
        position: sticky;
        top: 0;
        width: 280px;
        height: 100vh;
        height: 100dvh; /* Dynamic viewport height */
        flex-shrink: 0;
        transform: translateX(0);
        overflow-y: auto;
        padding-top: 20px;
        padding-bottom: 20px;
        /* Make sidebar scroll independently */
        align-self: flex-start;
    }

    .sidebar-overlay {
        display: none;
    }

    .main-content {
        flex: 1;
        min-width: 0;
        padding: 0;
        min-height: 100vh;
        min-height: 100dvh; /* Dynamic viewport height */
    }
}

/* ADDITIONAL: Ensure proper body and html height */
html, body {
    height: 100%;
    min-height: 100vh;
    min-height: 100dvh;
}

/* Impersonation Banner Enhancement */
.impersonation-banner {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.95));
    backdrop-filter: blur(16px);
    border: 1px solid rgba(59, 130, 246, 0.2);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Navigation List Styles */
.nav-list {
    padding: 0 0 20px 0;
}
    </style>
    @yield('styles')
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans">
    @php
        // Melakukan fetching data langsung di layout untuk menghitung jumlah pending.
        $complaintsPending = \App\Models\Complaint::where('status', 'pending')->count();
        $questionsPending = \App\Models\Question::where('status', 'pending')->count();
    @endphp

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

    <!-- Header khusus untuk Mobile -->
    <header class="mobile-header">
        <div class="flex items-center justify-between">
            <button id="sidebarToggle" class="mobile-toggle-btn text-white focus:outline-none relative p-2 rounded-lg">
                <i class="fas fa-bars fa-lg"></i>
                {{-- Badge untuk total pengaduan dan pertanyaan pending --}}
                @if ($complaintsPending + $questionsPending > 0)
                    <span class="badge absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white rounded-full min-w-[20px] h-5">
                        {{ $complaintsPending + $questionsPending }}
                    </span>
                @endif
            </button>
            <span id="realTimeClock" class="text-white font-semibold text-sm">Memuat Waktu...</span>
            <div class="w-10"></div>
        </div>
    </header>

    <!-- Overlay untuk Sidebar pada Mobile -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <!-- Header Sidebar -->
            <div class="sidebar-header">
                <div class="logo-container relative inline-block">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto">
                        <img src="{{ asset($logo ?? 'default-logo.png') }}" alt="{{ $apk }}"
                            class="w-full h-full object-cover rounded-full border-2 border-white/20 shadow-xl">
                    </div>
                </div>
                <h2 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-2">
                    {{ $apk }}
                </h2>
                <div class="divider"></div>
                @if (auth()->user()->name)
                    <div class="space-y-1">
                        <p class="text-white font-medium text-sm">{{ auth()->user()->name ?? 'User' }}</p>
                        <span class="inline-block px-2 sm:px-3 py-1 text-xs font-semibold bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Navigasi Sidebar -->
            <ul class="nav-list">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                        <span class="font-medium text-sm sm:text-base">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('complaint.list') }}"
                        class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('complaint') ? 'active' : '' }}">
                        <i class="fas fa-comment-alt mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                        <span class="font-medium text-sm sm:text-base">Pengaduan</span>
                        @if ($complaintsPending > 0)
                            <span class="badge ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white rounded-full min-w-[20px] h-5">
                                {{ $complaintsPending }}
                            </span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('faq.index') }}"
                        class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('faq') ? 'active' : '' }}">
                        <i class="fas fa-question-circle mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                        <span class="font-medium text-sm sm:text-base">FAQ</span>
                        @if ($questionsPending > 0)
                            <span class="badge ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white rounded-full min-w-[20px] h-5">
                                {{ $questionsPending }}
                            </span>
                        @endif
                    </a>
                </li>

                @if (auth()->user()->role == 'superAdmin')
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('user') ? 'active' : '' }}">
                            <i class="fas fa-users mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                            <span class="font-medium text-sm sm:text-base">Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('location.index') }}"
                            class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('location') ? 'active' : '' }}">
                            <i class="fas fa-map-marker-alt mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                            <span class="font-medium text-sm sm:text-base">Lokasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('setting.index') }}"
                            class="nav-item flex items-center p-3 sm:p-4 {{ request()->is('setting') ? 'active' : '' }}">
                            <i class="fas fa-cogs mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                            <span class="font-medium text-sm sm:text-base">Pengaturan</span>
                        </a>
                    </li>
                @endif

                <!-- Divider sebelum logout -->
                <li class="pt-4">
                    <div class="divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full nav-item flex items-center p-3 sm:p-4 text-red-400 hover:text-red-300 hover:bg-red-500/10 border-red-500/20">
                            <i class="fas fa-sign-out-alt mr-3 sm:mr-4 text-base sm:text-lg"></i> 
                            <span class="font-medium text-sm sm:text-base">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Konten Utama -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @if (session()->has('original_user_id'))
        <div id="impersonationBanner"
            class="impersonation-banner fixed top-4 right-4 z-50 rounded-xl p-4 max-w-xs">
            <div class="flex items-center justify-between mb-2">
                <h5 class="text-sm font-bold text-gray-800">Impersonasi Aktif</h5>
                <a href="{{ route('user.switch.back') }}"
                    class="text-xs font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 rounded-lg px-3 py-1 transition-all duration-200">
                    Kembali
                </a>
            </div>
            <p class="text-xs text-gray-700">
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

        function hideSpinner() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Tampilkan spinner saat berpindah halaman
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll("a");
            links.forEach(link => {
                link.addEventListener("click", function(event) {
                    if (link.getAttribute("target") !== "_blank" && link.getAttribute("href") !== "#") {
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

        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar untuk mobile
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('active');
            });

            // Close sidebar ketika overlay diklik
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
            });

            // Close sidebar ketika link diklik (mobile)
            const navLinks = sidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 640) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 640) {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('active');
                }
            });
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