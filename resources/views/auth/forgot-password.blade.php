<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - {{ $apk }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #3b82f6 0%, #e5e7eb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        .bg-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 10%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 70%;
            right: 10%;
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, #48cae4, #023e8a);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 20%;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #a8e6cf, #88d8c0);
            border-radius: 50%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Glassmorphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        }

        /* Loading overlay */
        #loadingOverlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
        }

        .spinner::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 4px solid transparent;
            border-top: 4px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom button hover effect */
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        /* Input focus effect */
        .input-modern {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .input-modern:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .input-modern::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Back button modern style */
        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">
    <!-- Animated background shapes -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- Back button -->
    <div class="fixed top-6 left-6 z-50">
        <a href="{{ route('login') }}" class="back-btn flex items-center space-x-3 px-2 py-2 rounded-2xl text-white font-medium transition-all duration-300">
            <i class="fas fa-arrow-left text-lg"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Main container -->
    <div class="glass-card rounded-3xl overflow-hidden max-w-md w-full relative z-10">
        <!-- Header section -->
        <div class="p-8 pb-6 text-center">
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full blur-sm opacity-75"></div>
                    <img src="{{ asset($logo) }}" alt="{{ $apk }}" class="relative w-20 h-20 rounded-full border-2 border-white/30 shadow-2xl">
                </div>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">{{ $apk }}</h1>
            <p class="text-white/80 text-sm font-medium">Lupa Password?</p>
            <p class="text-white/60 text-xs mt-2">Masukkan email Anda untuk mendapatkan link reset password</p>
        </div>

        <!-- Form section -->
        <div class="px-8 pb-8">
            <!-- Hidden session messages for toastr -->
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

            <!-- Visible alerts -->
            @if (session('success'))
                <div class="mb-6 p-4 text-sm text-green-100 bg-green-500/20 border border-green-500/30 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 text-sm text-red-100 bg-red-500/20 border border-red-500/30 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 text-sm text-red-100 bg-red-500/20 border border-red-500/30 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <!-- Forgot password form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div class="relative">
                    <label for="email" class="block font-medium text-white/90 mb-3 text-sm">
                        <i class="fas fa-envelope mr-2"></i>Alamat Email
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           placeholder="Masukkan alamat email Anda" 
                           required
                           class="input-modern w-full px-4 py-4 rounded-xl text-white placeholder-white/70 focus:outline-none transition-all duration-300">
                </div>
                
                <button type="submit" class="btn-modern w-full py-4 text-white font-semibold bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Additional info -->
            <div class="mt-6 text-center">
                <p class="text-white/60 text-xs">
                    <i class="fas fa-info-circle mr-1"></i>
                    Link reset akan dikirim ke email Anda dalam beberapa menit
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Configure toastr
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            // Form submission loading
            $('form').on('submit', function() {
                $('#loadingOverlay').fadeIn(300);
            });

            // Display toastr notifications
            var successMessage = $('#session-success').text().trim();
            if (successMessage) {
                toastr.success(successMessage, 'Berhasil!');
            }
            
            var errorMessage = $('#session-error').text().trim();
            if (errorMessage) {
                toastr.error(errorMessage, 'Error!');
            }
            
            var validationErrors = $('#validation-errors').html();
            if (validationErrors) {
                toastr.error(validationErrors, 'Validation Error!');
            }

            // Input focus effects
            $('.input-modern').on('focus', function() {
                $(this).parent().addClass('scale-105');
            }).on('blur', function() {
                $(this).parent().removeClass('scale-105');
            });
        });
    </script>
</body>

</html>