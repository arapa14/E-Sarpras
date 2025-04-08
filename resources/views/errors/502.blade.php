<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $apk }} - 502 Bad Gateway</title>
    <!-- Favicon SVG inline -->
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><text y='14' font-size='16'>🌐</text></svg>">
    <!-- Tailwind CSS CDN terbaru -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Animasi tombol */
        .btn-animate {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .btn-animate:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Animasi ikon berputar */
        .icon-spin-slow {
            animation: icon-spin 3s linear infinite;
        }

        @keyframes icon-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Animasi fade-in pada kontainer utama */
        .fade-in {
            animation: fadeIn 1.5s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-200 via-indigo-200 to-purple-200 flex items-center justify-center">
    <div class="container mx-auto px-4 py-8 fade-in">
        <!-- Header -->
        <header class="flex flex-col items-center mb-12">
            <div class="flex items-center space-x-4">
                <img src="{{ asset($logo) }}" alt="{{ $apk }} Logo"
                    class="h-24 w-24 rounded-full shadow-xl border-4 border-white">
                <i class="fas fa-network-wired fa-3x text-indigo-700 icon-spin-slow"></i>
            </div>
            <h1 class="mt-6 text-5xl font-extrabold text-gray-800 flex items-center space-x-3">
                <span>{{ $apk }}</span>
                <i class="fas fa-info-circle text-blue-500"></i>
            </h1>
        </header>
        <!-- Main Content -->
        <main
            class="bg-white bg-opacity-90 backdrop-blur-sm rounded-2xl shadow-2xl border-t-4 border-transparent bg-clip-padding p-12 max-w-xl mx-auto text-center"
            style="background-image: linear-gradient(to right, #60a5fa, #6366f1); background-origin: border-box;">
            <h2 class="text-8xl font-extrabold text-white mb-4 drop-shadow-lg animate-pulse">502</h2>
            <h3 class="text-4xl font-semibold text-white mb-4">Bad Gateway</h3>
            <p class="text-xl text-gray-100 mb-8">
                Maaf, terjadi kesalahan pada server atau gateway. Silakan coba lagi beberapa saat.
            </p>
            <a href="{{ url('/') }}"
                class="inline-block px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-medium btn-animate transition duration-200 shadow-lg">
                Kembali ke Beranda
            </a>
        </main>
        <!-- Footer -->
        <footer class="mt-12 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} {{ $apk }}. All rights reserved.
        </footer>
    </div>
</body>

</html>
