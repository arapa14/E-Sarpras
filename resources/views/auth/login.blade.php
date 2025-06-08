<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $name ?? 'Login' }}</title>
    <!-- <link rel="icon" type="image/png" href="{{ asset($logo ?? 'logo.png') }}" /> -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #e5e7eb 100%);
        }
        
        .main-container {
            min-height: 100vh;
        }
        
        .tab-active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
            font-weight: 600;
        }
        
        .tab-inactive {
            color: #9ca3af;
            border-bottom: 2px solid transparent;
        }
        
        .illustration-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .floating-element {
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-element:nth-child(2) {
            animation-delay: -1s;
        }
        
        .floating-element:nth-child(3) {
            animation-delay: -2s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .input-group {
            position: relative;
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
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
        
        /* Mobile First Responsive Design */
        .left-panel {
            min-height: 40vh;
        }
        
        .right-panel {
            min-height: 60vh;
        }
        
        .form-wrapper {
            padding: 1rem;
        }
        
        .compact-header {
            margin-bottom: 1.5rem;
        }
        
        .compact-form {
            gap: 1rem;
        }
        
        .compact-input {
            padding: 0.75rem 1rem;
        }
        
        /* Mobile Branding Section */
        .mobile-branding {
            padding: 2rem 1rem;
            text-align: center;
        }
        
        .mobile-branding h1 {
            font-size: 1.875rem;
            font-weight: bold;
            color: white;
            margin-bottom: 0.5rem;
        }
        
        .mobile-branding p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
        }
        
        .mobile-features {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .mobile-feature {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 0.75rem;
            padding: 0.75rem;
            color: white;
            font-size: 0.75rem;
            min-width: 80px;
            text-align: center;
        }
        
        /* Tablet Styles */
        @media (min-width: 768px) {
            .main-container {
                flex-direction: row;
            }
            
            .left-panel {
                min-height: 100vh;
                width: 40%;
            }
            
            .right-panel {
                width: 60%;
                min-height: 100vh;
            }
            
            .form-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 2rem;
            }
            
            .mobile-branding {
                display: none;
            }
            
            .desktop-branding {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 100%;
                padding: 2rem;
                text-align: center;
                color: white;
                position: relative;
                z-index: 10;
            }
        }
        
        /* Desktop Styles */
        @media (min-width: 1024px) {
            .left-panel {
                width: 50%;
            }
            
            .right-panel {
                width: 50%;
            }
            
            .desktop-branding h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            
            .desktop-branding p {
                font-size: 1rem;
                opacity: 0.9;
            }
        }
        
        /* Mobile specific adjustments */
        @media (max-width: 767px) {
            .main-container {
                flex-direction: column;
            }
            
            .left-panel {
                order: 1;
            }
            
            .right-panel {
                order: 2;
            }
            
            .compact-header {
                margin-bottom: 1rem;
            }
            
            .compact-form {
                gap: 0.75rem;
            }
            
            .compact-input {
                padding: 0.875rem 1rem;
            }
            
            .floating-element {
                display: none;
            }
            
            .desktop-branding {
                display: none;
            }
        }
        
        /* Very small screens */
        @media (max-width: 375px) {
            .mobile-branding {
                padding: 1.5rem 1rem;
            }
            
            .mobile-branding h1 {
                font-size: 1.5rem;
            }
            
            .form-wrapper {
                padding: 0.75rem;
            }
            
            .mobile-features {
                flex-direction: column;
                align-items: center;
            }
            
            .mobile-feature {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Back Button Floating -->
    <div class="fixed top-4 left-4 z-50">
        <a href="/"
            class="flex items-center space-x-2 bg-white shadow-md px-3 py-2 rounded-full hover:bg-gray-100 transition">
            <!-- Icon panah kiri -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-blue-600 font-medium">Kembali</span>
        </a>
    </div>

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

    <div class="main-container flex flex-col md:flex-row">
        <!-- Left panel / Branding Panel -->
        <div class="gradient-bg relative overflow-hidden left-panel">
            <!-- Mobile Branding (visible on mobile) -->
            <div class="mobile-branding md:hidden">
                <h1>E-Sarpras</h1>
                <p>Mudah digunakan, Informasi Real-time, dan Transparan.</p>
                <div class="mobile-features">
                    <div class="mobile-feature">
                        <div class="text-lg mb-1">✅</div>
                        <div>Mudah</div>
                    </div>
                    <div class="mobile-feature">
                        <div class="text-lg mb-1">⏰</div>
                        <div>Real-time</div>
                    </div>
                    <div class="mobile-feature">
                        <div class="text-lg mb-1">📜</div>
                        <div>Transparan</div>
                    </div>
                </div>
            </div>

            <!-- Desktop Branding (visible on tablet and desktop) -->
            <div class="desktop-branding hidden md:flex">
                <!-- Decorative floating elements -->
                <div class="absolute top-16 left-16 w-12 h-12 bg-white rounded-full floating-element opacity-60"></div>
                <div class="absolute top-32 right-24 w-8 h-8 bg-white rounded-full floating-element opacity-50"></div>
                <div class="absolute bottom-24 left-12 w-16 h-16 bg-white rounded-full floating-element opacity-40"></div>
                <div class="absolute bottom-16 right-16 w-6 h-6 bg-white rounded-full floating-element opacity-70"></div>
                
                <!-- Main Illustration Cards -->
                <div class="mb-6 relative">
                    <!-- E-Sarpras Card -->
                    <div class="illustration-card rounded-xl p-4 mb-3 w-56 transform rotate-2">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                <span class="text-lg">🏆</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="font-bold text-base">E-Sarpras</h3>
                                <p class="text-xs opacity-90">memudahkan anda melaporkan kerusakan, memantau perbaikan, dan mendapatkan informasi real-time</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="w-5 h-5 bg-blue-400 rounded-full flex items-center justify-center">
                                <span class="text-xs">🎯</span>
                            </div>
                            <div class="w-5 h-5 bg-purple-400 rounded-full flex items-center justify-center">
                                <span class="text-xs">⭐</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fitur card-->
                    <div class="illustration-card rounded-xl p-4 w-56 transform -rotate-1 ml-6">
                        <h3 class="font-bold text-base mb-3">Fitur unggulan</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                                    <span class="text-xs">✅</span>
                                </div>
                                <span class="text-xs">Mudah Digunakan</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                                    <span class="text-xs">⏰</span>
                                </div>
                                <span class="text-xs">real-time</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                                    <span class="text-xs">📜</span>
                                </div>
                                <span class="text-xs">Transparan</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- teks bawah branding panel -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold mb-3">E-Sarpras</h1>
                    <p class="text-base opacity-90">
                    Mudah digunakan, Informasi Real-time, dan Transparan.
                    </p>
                    <div class="flex justify-center mt-4 space-x-2">
                        <div class="w-6 h-2 bg-white rounded-full"></div>
                        <div class="w-2 h-2 bg-white opacity-50 rounded-full"></div>
                        <div class="w-2 h-2 bg-white opacity-30 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel -->
        <div class="right-panel bg-white">
            <div class="form-wrapper">
                <div class="w-full max-w-md mx-auto">
                    <!-- Header -->
                    <div class="text-center compact-header">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back!</h1>
                        <p class="text-sm text-gray-600">
                        Silahkan login untuk membuat pengaduan atau mendaftar akun baru.
                        </p>
                    </div>

                    <!-- Tab Navigation -->
                    <div class="flex justify-center mb-6 bg-gray-100 rounded-lg p-1">
                        <button id="loginTab" 
                            class="flex-1 py-2 px-4 text-center rounded-md transition-all duration-300 tab-active">
                            Login
                        </button>
                        <button id="registerTab" 
                            class="flex-1 py-2 px-4 text-center rounded-md transition-all duration-300 tab-inactive">
                            Register
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form id="loginForm" method="POST" action="{{ route('login.submit') }}" class="compact-form space-y-4">
                        @csrf
                        <div class="input-group">
                            <label for="login_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" 
                                name="email" 
                                id="login_email" 
                                placeholder="Masukan email anda"
                                value="{{ old('email') }}"
                                class="input-field compact-input w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <div id="loginEmailError" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid</div>
                        </div>

                        <div class="input-group">
                            <label for="login_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" 
                                    name="password" 
                                    id="login_password" 
                                    placeholder="••••••••••"
                                    class="input-field compact-input w-full pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <button type="button" 
                                    onclick="togglePassword('login_password', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 text-gray-700">Remember Me</label>
                            </div>
                            <a href="{{ route('password.request') }}" 
                                class="text-blue-600 hover:text-blue-500">Recovery Password</a>
                        </div>

                        <button type="submit" 
                            class="btn-primary w-full py-2.5 px-4 text-white font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Login
                        </button>

                        <div class="text-center">
                            <span class="text-gray-500 text-sm">or</span>
                        </div>

                        <button type="button" 
                            class="w-full py-2.5 px-4 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-300 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span>Sign in with Google</span>
                        </button>
                    </form>

                    <!-- Register Form -->
                    <form id="registerForm" method="POST" action="{{ route('register.submit') }}" class="compact-form space-y-4 hidden">
                        @csrf
                        <div class="input-group">
                            <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" 
                                name="name" 
                                id="register_name" 
                                placeholder="alg"
                                value="{{ old('name') }}"
                                class="input-field compact-input w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>

                        <div class="input-group">
                            <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" 
                                name="email" 
                                id="register_email" 
                                placeholder="smkn1jakarta@gmail.com"
                                value="{{ old('email') }}"
                                class="input-field compact-input w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <div id="registerEmailError" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid</div>
                        </div>

                        <div class="input-group">
                            <label for="register_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="text" 
                                name="whatsapp" 
                                id="register_whatsapp" 
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('whatsapp') }}"
                                class="input-field compact-input w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <div id="whatsappError" class="text-red-500 text-xs mt-1 hidden">Nomor WhatsApp harus berupa angka dan minimal 10 digit</div>
                        </div>

                        <div class="input-group">
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" 
                                    name="password" 
                                    id="register_password" 
                                    placeholder="masukan kata sandi"
                                    class="input-field compact-input w-full pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <button type="button" 
                                    onclick="togglePassword('register_password', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <div id="registerPasswordError" class="text-red-500 text-xs mt-1 hidden">Password harus minimal 8 karakter</div>
                        </div>

                        <div class="input-group">
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" 
                                    name="password_confirmation" 
                                    id="register_password_confirmation" 
                                    placeholder="konfirmasi kata sandi"
                                    class="input-field compact-input w-full pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <button type="button" 
                                    onclick="togglePassword('register_password_confirmation', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <div id="registerPasswordConfirmationError" class="text-red-500 text-xs mt-1 hidden">Konfirmasi password tidak sesuai</div>
                        </div>

                        <button type="submit" 
                            class="btn-primary w-full py-2.5 px-4 text-white font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Sign Up
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p id="switchText" class="text-gray-600 text-sm">
                            Don't have an account yet? 
                            <button id="switchToRegister" class="text-blue-600 hover:text-blue-500 font-semibold">Sign Up</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function showSpinner() {
    document.getElementById('loadingOverlay').style.display = 'block';
}
        document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();
    if (validateRegisterForm()) {
        showSpinner(); 
        this.submit();
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
    this.submit();
});
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
            
            switchText.innerHTML = 'Don\'t have an account yet? <button id="switchToRegister" class="text-blue-600 hover:text-blue-500 font-semibold">Sign Up</button>';
            document.getElementById('switchToRegister').addEventListener('click', showRegister);
        }

        function showRegister() {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            registerTab.classList.add('tab-active');
            registerTab.classList.remove('tab-inactive');
            loginTab.classList.add('tab-inactive');
            loginTab.classList.remove('tab-active');
            
            switchText.innerHTML = 'Already have an account? <button id="switchToLogin" class="text-blue-600 hover:text-blue-500 font-semibold">Login</button>';
            document.getElementById('switchToLogin').addEventListener('click', showLogin);
        }

        loginTab.addEventListener('click', showLogin);
        registerTab.addEventListener('click', showRegister);

        @if (session('form') == 'register')
            showRegister();
        @else
            showLogin();
        @endif

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            
            input.type = isPassword ? 'text' : 'password';
            
            const svg = button.querySelector('svg');
            if (isPassword) {
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.66-4.252M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.293 5.423"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                `;
            } else {
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        function validateWhatsApp(phone) {
            const regex = /^\d{10,}$/;
            return regex.test(phone);
        }

        // Real-time validation
        document.getElementById('login_email').addEventListener('input', function() {
            const error = document.getElementById('loginEmailError');
            if (!validateEmail(this.value) && this.value.length > 0) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });

        document.getElementById('register_email').addEventListener('input', function() {
            const error = document.getElementById('registerEmailError');
            if (!validateEmail(this.value) && this.value.length > 0) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });

        document.getElementById('register_whatsapp').addEventListener('input', function() {
            const error = document.getElementById('whatsappError');
            if (!validateWhatsApp(this.value) && this.value.length > 0) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });

        document.getElementById('register_password').addEventListener('input', function() {
            const error = document.getElementById('registerPasswordError');
            if (this.value.length < 8 && this.value.length > 0) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
            
            const confirmation = document.getElementById('register_password_confirmation');
            if (confirmation.value) {
                validatePasswordConfirmation();
            }
        });

        document.getElementById('register_password_confirmation').addEventListener('input', validatePasswordConfirmation);

        function validatePasswordConfirmation() {
            const password = document.getElementById('register_password').value;
            const confirmation = document.getElementById('register_password_confirmation').value;
            const error = document.getElementById('registerPasswordConfirmationError');
            
            if (confirmation && password !== confirmation) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        }

        // Form submissions
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('login_email').value.trim();
            const password = document.getElementById('login_password').value.trim();
            
            if (!email || !password) {
                toastr.error('Email dan password harus diisi');
                return;
            }
            
            if (!validateEmail(email)) {
                toastr.error('Format email tidak valid');
                return;
            }
            
            showSpinner();
            this.submit();
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('register_name').value.trim();
            const email = document.getElementById('register_email').value.trim();
            const whatsapp = document.getElementById('register_whatsapp').value.trim();
            const password = document.getElementById('register_password').value.trim();
            const confirmation = document.getElementById('register_password_confirmation').value.trim();
            
            if (!name || !email || !whatsapp || !password || !confirmation) {
                toastr.error('Semua field harus diisi');
                return;
            }
            
            if (!validateEmail(email)) {
                toastr.error('Format email tidak valid');
                return;
            }
            
            if (!validateWhatsApp(whatsapp)) {
                toastr.error('Nomor WhatsApp harus berupa angka dan minimal 10 digit');
                return;
            }
            
            if (password.length < 8) {
                toastr.error('Password harus minimal 8 karakter');
                return;
            }
            
            if (password !== confirmation) {
                toastr.error('Konfirmasi password tidak sesuai');
                return;
            }
            
            showSpinner();
            this.submit();
        });
        function showSpinner() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }
        function hideSpinner() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
        window.addEventListener('beforeunload', function() {
            hideSpinner();
        });
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif

        @if (session('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif

        @if (session('info'))
            toastr.info('{{ session('info') }}');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
        document.querySelectorAll('.input-field').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Auto-format WhatsApp number
        document.getElementById('register_whatsapp').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 15) {
                value = value.substr(0, 15);
            }
            
            this.value = value;
        });

        let isSubmitting = false;
        
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                if (isSubmitting) {
                    return false;
                }
                isSubmitting = true;
                
                // Reset after 5 seconds as fallback
                setTimeout(function() {
                    isSubmitting = false;
                    hideSpinner();
                }, 5000);
            });
        });

        // Handle browser back button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                hideSpinner();
                isSubmitting = false;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const switchToRegister = document.getElementById('switchToRegister');
            if (switchToRegister) {
                switchToRegister.addEventListener('click', showRegister);
            }
        });
    </script>
</body>
</html>