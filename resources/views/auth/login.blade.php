<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $name }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    @vite('resources/css/app.css')
    <!-- Sertakan CSS Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
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

        /* Styling untuk overlay spinner */
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

<body class="bg-gradient-to-r from-blue-100 to-blue-50 font-sans">
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

    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">
        <div class="bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden">
            <!-- Branding Panel -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-700 text-white flex flex-col justify-center items-center p-8 md:p-12 w-full md:w-1/2">
                <img src="{{ asset($logo) }}" alt="Logo {{ $name }}" class="w-24 sm:w-28 md:w-36 mb-6"
                    loading="lazy">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">{{ $name }}</h1>
                <p class="mt-4 text-center text-sm sm:text-base">Silahkan login untuk membuat pengaduan</p>
            </div>
            <!-- Form Panel -->
            <div class="flex flex-col p-6 sm:p-8 md:p-12 w-full md:w-1/2 form-container">
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
                    <a href="/" role="tab" aria-selected="false"
                        class="px-6 py-2 text-lg font-semibold border-b-4 transition-colors duration-300 focus:outline-none tab-inactive">
                        Kembali
                    </a>
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
                                required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-describedby="emailError" oninput="validateLoginEmail(this)" />
                            <p id="emailError" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid.</p>
                        </div>
                        <div>
                            <label for="login_password" class="block text-gray-700 font-medium mb-2">Kata Sandi</label>
                            <input type="password" name="password" id="login_password" placeholder="Masukkan kata sandi"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                aria-describedby="passwordError" oninput="validatePassword(this)" />
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
                                placeholder="Masukkan nama lengkap anda" required value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label for="register_email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" id="register_email" placeholder="Masukkan email anda"
                                required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="validateRegisterEmail(this)" />
                            <p id="registerEmailError" class="text-red-500 text-xs mt-1 hidden">Format email tidak
                                valid.</p>
                        </div>
                        <div>
                            <label for="register_whatsapp" class="block text-gray-700 font-medium mb-2">Nomor
                                WhatsApp</label>
                            <input type="text" name="whatsapp" id="register_whatsapp" placeholder="08xxxxxxxxxx"
                                required value="{{ old('whatsapp') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="validateWhatsApp(this)" />
                            <p id="whatsappError" class="text-red-500 text-xs mt-1 hidden">Nomor WhatsApp harus berupa
                                angka dan minimal 10 digit.</p>
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="register_password" class="block text-gray-700 font-medium mb-2">Kata
                                Sandi</label>
                            <input type="password" name="password" id="register_password"
                                placeholder="Masukkan kata sandi" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="validateRegisterPassword(this)" />
                            <p id="registerPasswordError" class="text-red-500 text-xs mt-1 hidden">Password harus
                                minimal 8 karakter.</p>
                        </div>
                        <div>
                            <label for="register_password_confirmation"
                                class="block text-gray-700 font-medium mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="register_password_confirmation"
                                placeholder="Konfirmasi kata sandi" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="validatePasswordConfirmation(this)" />
                            <p id="registerPasswordConfirmationError" class="text-red-500 text-xs mt-1 hidden">
                                Konfirmasi password tidak sesuai.</p>
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
                        <a href="#" class="text-blue-600 hover:underline focus:outline-none">Reset Kata
                            Sandi</a>
                    </p>
                </div>
            </div>
            <!-- End Form Panel -->
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan spinner
        function showSpinner() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }

        // Validasi format email untuk login
        function validateLoginEmail(input) {
            const emailError = document.getElementById('emailError');
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(input.value)) {
                emailError.classList.remove('hidden');
            } else {
                emailError.classList.add('hidden');
            }
        }

        // Validasi format email untuk register
        function validateRegisterEmail(input) {
            const emailError = document.getElementById('registerEmailError');
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!regex.test(input.value)) {
                emailError.classList.remove('hidden');
            } else {
                emailError.classList.add('hidden');
            }
        }

        // Validasi kekuatan password minimal 8 karakter untuk register
        function validateRegisterPassword(input) {
            const passwordError = document.getElementById('registerPasswordError');
            if (input.value.length < 8) {
                passwordError.classList.remove('hidden');
            } else {
                passwordError.classList.add('hidden');
            }
            validatePasswordConfirmation(document.getElementById('register_password_confirmation'));
        }

        // Validasi kesesuaian antara password dan konfirmasi password
        function validatePasswordConfirmation(input) {
            const passwordInput = document.getElementById('register_password');
            const confirmationError = document.getElementById('registerPasswordConfirmationError');
            if (input.value !== passwordInput.value) {
                confirmationError.classList.remove('hidden');
            } else {
                confirmationError.classList.add('hidden');
            }
        }

        // Validasi nomor WhatsApp: hanya angka dan minimal 10 digit
        function validateWhatsApp(input) {
            const whatsappError = document.getElementById('whatsappError');
            const value = input.value.trim();
            const regex = /^\d+$/;
            if (!regex.test(value) || value.length < 10) {
                whatsappError.classList.remove('hidden');
            } else {
                whatsappError.classList.add('hidden');
            }
        }
    </script>

    <script>
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

        @if (session('form') == 'register')
            showRegister();
        @else
            showLogin();
        @endif

        // Navigasi antar field saat tekan Enter
        document.querySelectorAll("form").forEach(function(form) {
            const inputs = Array.from(form.querySelectorAll("input")).filter(
                (input) => input.type !== "hidden"
            );

            inputs.forEach((input, index) => {
                input.addEventListener("keydown", function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault(); // Mencegah submit default
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus(); // Pindah ke input berikutnya
                        }
                        // } else {
                        //     form.submit(); 
                        // }
                    }
                });
            });
        });
    </script>

    <!-- Sertakan jQuery dan Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Tempatkan script di akhir body -->
    <script>
        // Fungsi untuk menampilkan spinner
        function showSpinner() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }

        // Fungsi validasi untuk form register
        function validateRegisterForm() {
            let username = document.getElementById("register_name").value.trim();
            let email = document.getElementById("register_email").value.trim();
            let whatsapp = document.getElementById("register_whatsapp").value.trim();
            let password = document.getElementById("register_password").value.trim();
            let confirmPassword = document.getElementById("register_password_confirmation").value.trim();
            let valid = true;

            if (username === "") {
                toastr.error("Username tidak boleh kosong");
                valid = false;
            }
            if (email === "" || !email.includes("@")) {
                toastr.error("Masukkan email yang valid");
                valid = false;
            }
            if (!/^\d{10,}$/.test(whatsapp)) {
                toastr.error("Nomor WhatsApp harus berupa angka dan minimal 10 digit");
                valid = false;
            }
            if (password.length < 8) {
                toastr.error("Password harus minimal 8 karakter");
                valid = false;
            }
            if (password !== confirmPassword) {
                toastr.error("Konfirmasi password tidak cocok");
                valid = false;
            }
            return valid;
        }

        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Cegah submit default
            if (validateRegisterForm()) {
                showSpinner(); // Tampilkan spinner jika validasi berhasil
                this.submit(); // Submit langsung tanpa delay
            }
        });

        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let email = document.getElementById("login_email").value.trim();
            let password = document.getElementById("login_password").value.trim();
            if (email === "" || password === "") {
                toastr.error("Email dan password harus diisi");
                return;
            }
            showSpinner();
            this.submit(); // Submit langsung tanpa delay
        });


        // Pastikan kode di atas dijalankan setelah DOM siap
        document.addEventListener("DOMContentLoaded", function() {
            // Kode di atas sudah terpasang di sini atau pastikan dipanggil setelah DOM terload.
        });
    </script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
