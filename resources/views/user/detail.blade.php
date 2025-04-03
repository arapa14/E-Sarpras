@extends('layouts.user')

@section('content')
    <div class="max-w-5xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 bg-blue-600 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-white">Detail Pengaduan</h1>
                <!-- Tombol kembali untuk layar desktop -->
                <a href="{{ route('complaint.riwayat') }}"
                    class="hidden md:flex items-center bg-white text-blue-600 px-4 py-2 rounded-lg shadow-md hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Tombol kembali untuk mobile -->
            <div class="md:hidden px-6 pt-4">
                <a href="{{ route('complaint.riwayat') }}"
                    class="flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Konten Utama -->
            <div class="p-6">
                <!-- Informasi Pengaduan -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Informasi Pengaduan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600"><span class="font-bold">Deskripsi:</span> {{ $complaint->description }}
                            </p>
                            <p class="text-gray-600 mt-2"><span class="font-bold">Lokasi:</span> {{ $complaint->location }}
                            </p>
                            <p class="text-gray-600 mt-2"><span class="font-bold">Saran:</span> {{ $complaint->suggestion }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">
                                <span class="font-bold">Status:</span>
                                <span
                                    class="px-3 py-1 inline-block rounded-full text-sm font-semibold uppercase
                                @if ($complaint->status == 'pending') bg-yellow-100 text-yellow-600 
                                @elseif($complaint->status == 'progress') bg-blue-100 text-blue-600 
                                @elseif($complaint->status == 'selesai') bg-green-100 text-green-600 
                                @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </p>
                            <p class="text-gray-600 mt-2">
                                <span class="font-bold">Waktu Pengaduan:</span>
                                {{ $complaint->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Gambar Pengaduan -->
                @if ($complaint->before_image)
                    @php
                        $images = json_decode($complaint->before_image, true);
                    @endphp

                    @if (!empty($images) && is_array($images))
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Gambar Pengaduan</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar Pengaduan"
                                        class="w-full h-48 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">Tidak ada gambar yang tersedia.</p>
                    @endif
                @endif

                <!-- Divider yang diperbarui -->
                <div class="flex items-center my-8">
                    <div class="flex-grow border-t-2 border-gray-300"></div>
                    <span class="mx-4 text-lg font-medium text-gray-500 bg-white px-2">Respon Pengaduan</span>
                    <div class="flex-grow border-t-2 border-gray-300"></div>
                </div>

                <!-- Respon Pengaduan -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Respon Pengaduan</h2>
                    @if ($complaint->responses && $complaint->responses->isNotEmpty())
                        @foreach ($complaint->responses as $response)
                            <div class="mb-4 border border-gray-200 rounded-lg p-4 shadow-sm">
                                <p class="text-gray-700">
                                    <span class="font-bold">Feedback:</span> {{ $response->feedback }}
                                </p>
                                <p class="text-gray-500 mt-2">
                                    <span class="font-bold">Waktu Respon:</span>
                                    {{ \Carbon\Carbon::parse($response->response_time)->format('d-m-Y H:i') }}
                                </p>
                                @if ($response->after_image)
                                    <div class="mt-4">
                                        <h3 class="text-lg font-semibold text-gray-800">Gambar Setelah Respon</h3>
                                        <img src="{{ asset('storage/' . $response->after_image) }}" alt="Gambar Respon"
                                            class="w-full h-48 object-cover rounded-lg shadow-md">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600">Belum ada respon untuk pengaduan ini.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
