<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - {{ $apk }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- Sertakan CSS Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Background dengan radial gradient */
        body {
            background: radial-gradient(circle at top left, #e0f7fa, #f0f4c3);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-r from-blue-100 to-blue-50 font-sans">
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

    <!-- Container utama untuk forgot password -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-md w-full relative">
        <!-- Header dengan aksen gradient -->
        <div class="bg-gradient-to-r from-blue-200 to-blue-100 p-6 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset($logo) }}" alt="{{ $apk }}"
                    class="w-24 h-24 rounded-full border-2 border-blue-300 shadow-md">
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800">{{ $apk }}</h1>
            <p class="mt-1 text-lg text-gray-600">Lupa Password</p>
        </div>

        <!-- Konten Form -->
        <div class="p-6">
            <!-- Tempat penyimpanan pesan session (disembunyikan) agar bisa diambil oleh toastr -->
            @if (session('success'))
                <div id="session-success" class="hidden">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div id="session-error" class="hidden">{{ session('error') }}</div>
            @endif

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

            <!-- Form Forgot Password -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block font-medium text-gray-700 mb-2">Email Anda</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan Email Anda" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                </div>
                <button type="submit"
                    class="w-full py-3 text-white font-bold bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 shadow">
                    Kirim Link Reset Password
                </button>
            </form>
        </div>
    </div>

    <!-- Sertakan jQuery dan Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Script untuk menampilkan notifikasi toastr -->
    <script>
        $(document).ready(function() {
            var successMessage = $('#session-success').text().trim();
            if (successMessage) {
                toastr.success(successMessage);
            }

            var errorMessage = $('#session-error').text().trim();
            if (errorMessage) {
                toastr.error(errorMessage);
            }

            var validationErrors = $('#validation-errors').html();
            if (validationErrors) {
                toastr.error(validationErrors);
            }
        });
    </script>
</body>

</html>
