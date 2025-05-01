@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-6 py-12 space-y-12">
    <!-- 2.1: Input Ticket untuk Cek Status -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-lg">
      <h3 class="text-2xl font-semibold mb-4">Cek Status Laporan</h3>
      <form action="{{ route('anonim.check') }}" method="POST">
        @csrf
        <label for="ticket" class="block mb-2 font-medium">Kode Tiket</label>
        <input type="text" name="ticket" id="ticket" required
               class="w-full px-4 py-2 border rounded-xl mb-4" placeholder="XXXXXX...">
        <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-full">Cek Status</button>
      </form>
    </div>
    
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Laporan Anonim</h2>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('anonim.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="description" class="block text-lg font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="Jelaskan laporan Anda secara singkat...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-lg font-medium text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="Lokasi kejadian" value="{{ old('location') }}">
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="suggestion" class="block text-lg font-medium text-gray-700 mb-2">Saran</label>
                    <input type="text" name="suggestion" id="suggestion"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        placeholder="Saran perbaikan" value="{{ old('suggestion') }}">
                    @error('suggestion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="before_image" class="block text-lg font-medium text-gray-700 mb-2">Foto Sebelum</label>
                    <input type="file" name="before_image" id="before_image" class="w-full text-gray-700">
                    @error('before_image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition">
                    Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                const focusable = Array.from(form.querySelectorAll('input, textarea, select, button'))
                    .filter(el => !el.disabled && el.type !== 'hidden');

                form.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        const idx = focusable.indexOf(e.target);
                        if (idx > -1 && idx < focusable.length - 1) {
                            e.preventDefault();
                            focusable[idx + 1].focus();
                        }
                    }
                });
            });
        </script>
    @endsection
@endsection
