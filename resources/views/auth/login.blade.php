<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $name }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    @vite('resources/css/app.css')
    <style>
        /* Menyesuaikan tinggi otomatis berdasarkan konten */
        .form-container {
            min-height: auto;
        }

        /* Styling untuk tab aktif dan tidak aktif */
        .tab-active {
            border-color: #007bff;
            color: #007bff;
        }

        .tab-inactive {
            border-color: transparent;
            color: #6b7280;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-50 font-sans">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
            <!-- Branding Panel -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-700 text-white flex flex-col justify-center items-center p-8 md:p-12 w-full md:w-1/2">
                <img src="{{ asset($logo) }}" alt="Logo {{ $name }}" class="w-24 sm:w-28 md:w-36 mb-6"
                    loading="lazy">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">{{ $name }}</h1>
                <p class="mt-4 text-center text-sm sm:text-base">Selamat datang! Mulai perjalanan Anda bersama kami.</p>
            </div>
            <!-- Form Panel -->
            <div class="flex flex-col p-6 sm:p-8 md:p-12 w-full md:w-1/2 form-container">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Tabs Header -->
                <div class="flex justify-center md:justify-start mb-8" role="tablist">
                    <button id="loginTab" role="tab" aria-selected="true" aria-controls="loginForm"
                        class="px-6 py-2 text-lg font-semibold border-b-4 transition-colors duration-300 focus:outline-none tab-active">
                        Login
                    </button>
                    <button id="registerTab" role="tab" aria-selected="false" aria-controls="registerForm"
                        class="px-6 py-2 text-lg font-semibold border-b-4 transition-colors duration-300 focus:outline-none tab-inactive">
                        Register
                    </button>
                </div>
                <!-- Form Content -->
                <div class="space-y-6">
                    <!-- Login Form -->
                    <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="space-y-6"
                        novalidate>
                        @csrf
                        <div>
                            <label for="login_email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" id="login_email" placeholder="Masukkan email anda"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-describedby="emailError" oninput="validateEmail(this)" />
                            <p id="emailError" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid.</p>
                        </div>
                        <div>
                            <label for="login_password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                            <input type="password" name="password" id="login_password" placeholder="Masukkan kata sandi"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-describedby="passwordError" oninput="validatePassword(this)" />
                            <p id="passwordError" class="text-red-500 text-xs mt-1 hidden">Kata sandi minimal 8
                                karakter.</p>
                        </div>
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 rounded-lg text-white font-semibold hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Login
                        </button>
                    </form>
                    <!-- Register Form -->
                    <form id="registerForm" method="POST" action="{{ route('register.submit') }}"
                        class="space-y-6 hidden" novalidate>
                        @csrf
                        <div>
                            <label for="register_name" class="block text-gray-700 font-medium mb-2">Nama</label>
                            <input type="text" name="name" id="register_name"
                                placeholder="Masukkan nama lengkap anda" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="register_email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" id="register_email" placeholder="Masukkan email anda"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="register_whatsapp" class="block text-gray-700 font-medium mb-2">Nomor
                                WhatsApp</label>
                            <input type="text" name="whatsapp" id="register_whatsapp" placeholder="08xxxxxxxxxx"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Jika ingin menggunakan role default, masukkan hidden input -->
                        <input type="hidden" name="role" value="user" />
                        <div>
                            <label for="register_password" class="block text-gray-700 font-medium mb-2">Kata
                                Sandi</label>
                            <input type="password" name="password" id="register_password"
                                placeholder="Masukkan kata sandi" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="register_password_confirmation"
                                class="block text-gray-700 font-medium mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="register_password_confirmation"
                                placeholder="Konfirmasi kata sandi" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 rounded-lg text-white font-semibold hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Register
                        </button>
                    </form>
                </div>
                <!-- Link untuk switch form -->
                <div class="mt-2 text-center">
                    <p id="switchText" class="text-gray-600 text-sm">
                        Lupa password?
                        <a href="#" class="text-blue-600 hover:underline focus:outline-none">
                            Reset Kata Sandi
                        </a>
                    </p>
                </div>
            </div>
            <!-- End Form Panel -->
        </div>
    </div>

    <script>
        // Validasi sederhana untuk email dan password
        function validateEmail(input) {
            const emailError = document.getElementById('emailError');
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            emailError.classList.toggle('hidden', regex.test(input.value));
        }

        function validatePassword(input) {
            const passwordError = document.getElementById('passwordError');
            passwordError.classList.toggle('hidden', input.value.length >= 8);
        }

        // Switching tab login dan register
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const switchText = document.getElementById('switchText');

        function showLogin() {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('tab-active');
            loginTab.classList.remove('tab-inactive');
            registerTab.classList.add('tab-inactive');
            registerTab.classList.remove('tab-active');
            loginTab.setAttribute('aria-selected', 'true');
            registerTab.setAttribute('aria-selected', 'false');
            // Tampilkan link reset password di tampilan login
            switchText.innerHTML =
                'Lupa password? <a href="#" class="text-blue-600 hover:underline focus:outline-none">Reset Kata Sandi</a>';
        }

        function showRegister() {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            registerTab.classList.add('tab-active');
            registerTab.classList.remove('tab-inactive');
            loginTab.classList.add('tab-inactive');
            loginTab.classList.remove('tab-active');
            registerTab.setAttribute('aria-selected', 'true');
            loginTab.setAttribute('aria-selected', 'false');
            switchText.innerHTML =
                'Sudah punya akun? <button id="switchToLogin" class="text-blue-600 hover:underline focus:outline-none">Login</button>';
            document.getElementById('switchToLogin').addEventListener('click', showLogin);
        }

        loginTab.addEventListener('click', showLogin);
        registerTab.addEventListener('click', showRegister);
        // Set tampilan awal ke Login
        showLogin();

        // Script untuk berpindah field saat menekan tombol Enter
        // Mengabaikan input dengan tipe "hidden"
        document.querySelectorAll('form').forEach(function(form) {
            // Hanya ambil input yang terlihat
            const inputs = Array.from(form.querySelectorAll('input')).filter(input => input.type !== 'hidden');
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        // Jika bukan field terakhir, pindahkan fokus ke input berikutnya
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        } else {
                            // Jika sudah di field terakhir, submit form
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
