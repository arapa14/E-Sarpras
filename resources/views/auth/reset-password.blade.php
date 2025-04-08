<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - {{ $apk }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Sertakan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- Sertakan CSS Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        /* Background dengan radial gradient */
        body {
            background: radial-gradient(circle at top left, #e0f7fa, #f0f4c3);
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

<body class="min-h-screen flex items-center justify-center p-6 font-sans bg-gradient-to-r from-blue-100 to-blue-50">
    <!-- Tombol kembali ke halaman login (floating) -->
    <div class="fixed top-4 left-4 z-50">
        <a href="{{ route('login') }}"
            class="flex items-center space-x-2 bg-white shadow-md px-3 py-2 rounded-full hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-blue-600 font-medium">Kembali</span>
        </a>
    </div>

    <!-- Container Utama -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-md w-full relative">
        <!-- Header dengan aksen gradient -->
        <div class="bg-gradient-to-r from-blue-200 to-blue-100 p-6 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset($logo) }}" alt="{{ $apk }}"
                    class="w-24 h-24 rounded-full border-2 border-blue-300 shadow-md">
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800">{{ $apk }}</h1>
            <p class="mt-1 text-lg text-gray-600">Reset Password</p>
        </div>

        <!-- Konten Form -->
        <div class="p-6">
            <!-- Jika ada pesan validasi, simpan dalam elemen tersembunyi untuk ditampilkan dengan toastr -->
            @if ($errors->any())
                <div id="validation-errors" class="hidden">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Pesan Sukses/Error -->
            @if (session('success'))
                <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 border border-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-200 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-200 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Reset Password -->
            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Sembunyikan token dan email -->
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div>
                    <label for="password" class="block font-medium text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan password baru"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                        <button type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 toggle-password"
                            data-target="#password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block font-medium text-gray-700 mb-2">Konfirmasi Password
                        Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Konfirmasi password baru"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                        <button type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 toggle-password"
                            data-target="#password_confirmation">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full py-3 text-white font-bold bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 shadow">
                    Reset Password
                </button>
            </form>

            <!-- Link Kembali ke Halaman Login -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <!-- Sertakan jQuery dan Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Script untuk toggle password dan notifikasi toastr -->
    <script>
        $(document).ready(function() {
            // Toggle visibilitas password
            $('.toggle-password').click(function() {
                var targetInput = $($(this).data('target'));
                var icon = $(this).find('i');
                if (targetInput.attr('type') === 'password') {
                    targetInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    targetInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toastr session messages
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            // Validasi error toastr
            var validationErrors = $('#validation-errors').html();
            if (validationErrors) {
                toastr.error(validationErrors);
            }

            // 🌀 Tampilkan overlay loading saat form dikirim
            $('form').on('submit', function() {
                $('#loadingOverlay').fadeIn();
            });
        });
    </script>
</body>

</html>
