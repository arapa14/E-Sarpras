@extends('layouts.user')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Edit Profil</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5" id="profileForm">
                @csrf
                @method('PATCH')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="whatsapp" class="block text-gray-700 font-medium mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('whatsapp') border-red-500 @enderror">
                    @error('whatsapp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">
                        Password Baru (kosongkan jika tidak mengubah)
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password baru">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            onclick="togglePasswordVisibility('password', 'icon-password')">
                            <div id="icon-password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Ulangi password baru">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            onclick="togglePasswordVisibility('password_confirmation', 'icon-password-confirmation')">
                            <div id="icon-password-confirmation">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Update Profil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script untuk toggle password -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const inputField = document.getElementById(inputId);
            const iconContainer = document.getElementById(iconId);
            if (inputField.type === "password") {
                inputField.type = "text";
                // Ganti ikon menjadi mata terbuka (eye off)
                iconContainer.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.34-3.36" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
            </svg>`;
            } else {
                inputField.type = "password";
                // Kembalikan ikon menjadi mata tertutup
                iconContainer.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>`;
            }
        }
    </script>

    <!-- Script untuk memindahkan fokus dengan tombol Enter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profileForm');

            // Tambahkan event listener untuk submit form
            form.addEventListener('submit', function(e) {
                // Memanggil fungsi spinner sebelum proses submit
                showSpinner();
            });

            const inputs = Array.from(form.querySelectorAll('input'));
            // Menghilangkan input type="hidden" jika ada
            const visibleInputs = inputs.filter(input => input.type !== 'hidden');

            visibleInputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        // Jika bukan field terakhir, pindah ke input berikutnya
                        if (index < visibleInputs.length - 1) {
                            visibleInputs[index + 1].focus();
                        } else {
                            showSpinner();
                            // Jika field terakhir, submit form
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
@endsection
