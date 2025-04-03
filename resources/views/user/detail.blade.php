@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-8 py-4 bg-blue-600">
                <h1 class="text-3xl font-bold text-white">Detail Pengaduan</h1>
                <!-- Tombol kembali desktop -->
                <a href="{{ route('complaint.riwayat') }}"
                    class="hidden md:flex items-center bg-white text-blue-600 px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Tombol kembali mobile -->
            <div class="px-8 pt-4 md:hidden">
                <a href="{{ route('complaint.riwayat') }}"
                    class="flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="p-8">
                <!-- Informasi Pengaduan -->
                <section class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Informasi Pengaduan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <p class="text-gray-700">
                                <span class="font-bold">Deskripsi:</span> {{ $complaint->description }}
                            </p>
                            <p class="text-gray-700">
                                <span class="font-bold">Lokasi:</span> {{ $complaint->location }}
                            </p>
                            <p class="text-gray-700">
                                <span class="font-bold">Saran:</span> {{ $complaint->suggestion }}
                            </p>
                        </div>
                        <div class="space-y-4">
                            <p class="text-gray-700">
                                <span class="font-bold">Status:</span>
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-sm font-semibold uppercase
                                    @if ($complaint->status == 'pending') bg-yellow-100 text-yellow-600 
                                    @elseif($complaint->status == 'progress') bg-blue-100 text-blue-600 
                                    @elseif($complaint->status == 'selesai') bg-green-100 text-green-600 
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </p>
                            <p class="text-gray-700">
                                <span class="font-bold">Waktu Pengaduan:</span>
                                {{ $complaint->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Gambar Pengaduan -->
                @if ($complaint->before_image)
                    @php
                        $images = json_decode($complaint->before_image, true);
                    @endphp
                    @if (!empty($images) && is_array($images))
                        <section class="mb-10">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">Gambar Pengaduan</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                                @foreach ($images as $image)
                                    <div
                                        class="overflow-hidden rounded-2xl shadow-lg transform transition duration-300 hover:scale-105 bg-gray-100">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gambar Pengaduan"
                                            class="w-full max-h-80 object-contain p-4">
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @else
                        <p class="text-gray-500">Tidak ada gambar yang tersedia.</p>
                    @endif
                @endif

                <!-- Divider -->
                <div class="flex items-center my-10">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="px-4 text-lg text-gray-500">Balasan Pengaduan</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Respon Pengaduan -->
                <section class="mb-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-8">Respon Pengaduan</h2>
                    @if ($complaint->responses && $complaint->responses->isNotEmpty())
                        @foreach ($complaint->responses as $response)
                            @php
                                // Konversi menit menjadi hari, jam, dan menit
                                $totalMinutes = $response->response_time;
                                $days = intdiv($totalMinutes, 1440);
                                $remainingMinutes = $totalMinutes % 1440;
                                $hours = intdiv($remainingMinutes, 60);
                                $minutes = $remainingMinutes % 60;

                                $timeString = '';
                                if ($days > 0) {
                                    $timeString .= $days . ' Hari ';
                                }
                                if ($hours > 0) {
                                    $timeString .= $hours . ' Jam ';
                                }
                                if ($minutes > 0 || $timeString === '') {
                                    $timeString .= $minutes . ' Menit';
                                }

                                // Decode JSON gambar after_image
                                $afterImages = json_decode($response->after_image, true);
                            @endphp

                            <div
                                class="bg-gray-50 border border-gray-200 rounded-2xl p-8 mb-8 shadow transition transform hover:shadow-2xl">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <h3 class="text-xl font-semibold text-gray-800">Respons</h3>
                                    <p class="text-gray-500 mt-2 sm:mt-0">
                                        <span class="font-bold">Waktu Respon:</span> {{ $timeString }}
                                    </p>
                                </div>
                                <p class="text-gray-700 mt-4">{{ $response->feedback }}</p>

                                <!-- Menampilkan multiple gambar after_image -->
                                @if (!empty($afterImages) && is_array($afterImages))
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Gambar Setelah Respon</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                                            @foreach ($afterImages as $afterImage)
                                                <div
                                                    class="overflow-hidden rounded-2xl shadow-lg transform transition duration-300 hover:scale-105 bg-gray-100">
                                                    <img src="{{ asset('storage/' . $afterImage) }}" alt="Gambar Respon"
                                                        class="w-full max-h-80 object-contain p-4">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600">Belum ada respon untuk pengaduan ini.</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
@endsection
