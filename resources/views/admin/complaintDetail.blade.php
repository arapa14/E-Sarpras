@extends('layouts.admin')

@section('styles')
    <style>
        .section-title {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold mb-4">Detail Pengaduan</h1>
            <div class="mb-6">
                <h2 class="text-xl font-semibold section-title">Informasi Pengaduan</h2>
                <p><strong>User:</strong> {{ $complaint->user->name }}</p>
                <p><strong>Deskripsi:</strong> {{ $complaint->description }}</p>
                <p><strong>Lokasi:</strong> {{ $complaint->location }}</p>
                <p><strong>Saran:</strong> {{ $complaint->suggestion }}</p>
                <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y H:i') }}</p>
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Gambar Sebelum</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $beforeImages = json_decode($complaint->before_image, true);
                        @endphp
                        @if ($beforeImages && count($beforeImages) > 0)
                            @foreach ($beforeImages as $image)
                                <div class="border p-2 rounded shadow">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar Sebelum"
                                        class="object-contain w-full h-48">
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">Tidak ada gambar.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h2 class="text-xl font-semibold section-title">Balas Pengaduan</h2>
                <!-- Form menggunakan route response.store -->
                <form action="{{ route('response.store', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="after_image" class="block text-sm font-medium text-gray-700">Gambar Sesudah
                            (Opsional)</label>
                        <input type="file" id="after_image" name="after_image" accept="image/*"
                            class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status Pengaduan</label>
                        <select id="status" name="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="progress" {{ $complaint->status == 'progress' ? 'selected' : '' }}>Progress
                            </option>
                            <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Tambahan script jika diperlukan, misalnya preview gambar
    </script>
@endsection
