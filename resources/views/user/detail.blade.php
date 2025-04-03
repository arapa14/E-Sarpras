@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto p-1 sm:p-6">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between px-6 py-4 bg-blue-600">
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 sm:mb-0">Detail Pengaduan</h1>
                <a href="{{ route('complaint.riwayat') }}"
                    class="w-full sm:w-auto flex items-center justify-center bg-white text-blue-600 px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left text-lg mr-2"></i> Kembali
                </a>
            </div>

            <!-- Konten Utama -->
            <div class="p-4 sm:p-8">
                <!-- Informasi Pengaduan -->
                <section class="mb-8">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4">Informasi Pengaduan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <p class="text-gray-700 text-base">
                                <span class="font-bold">Deskripsi:</span> {{ $complaint->description }}
                            </p>
                            <p class="text-gray-700 text-base">
                                <span class="font-bold">Lokasi:</span> {{ $complaint->location }}
                            </p>
                            <p class="text-gray-700 text-base">
                                <span class="font-bold">Saran:</span> {{ $complaint->suggestion }}
                            </p>
                        </div>
                        <div class="space-y-3">
                            <p class="text-gray-700 text-base">
                                <span class="font-bold">Status:</span>
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-sm font-semibold uppercase 
                                    @if ($complaint->status == 'pending') bg-yellow-100 text-yellow-700 border border-yellow-500
                                    @elseif($complaint->status == 'progress') bg-blue-100 text-blue-700 border border-blue-500
                                    @elseif($complaint->status == 'selesai') bg-green-100 text-green-700 border border-green-500
                                    @else bg-gray-200 text-gray-700 @endif">
                                    {{ ucfirst($complaint->status) }}
                                </span>
                            </p>
                            <p class="text-gray-700 text-base">
                                <span class="font-bold">Waktu Pengaduan:</span>
                                {{ $complaint->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Gambar Pengaduan -->
                @if ($complaint->before_image)
                    @php $images = json_decode($complaint->before_image, true); @endphp
                    @if (!empty($images) && is_array($images))
                        <section class="mb-8">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Foto Pengaduan</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach ($images as $image)
                                    <div class="overflow-hidden rounded-lg shadow hover:shadow-lg transition duration-300">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gambar Pengaduan"
                                            class="w-full h-28 sm:h-32 object-contain p-2 cursor-pointer"
                                            onclick="openImagesModal('{{ json_encode([$image]) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @else
                        <p class="text-gray-500">Tidak ada gambar yang tersedia.</p>
                    @endif
                @endif

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="px-4 text-base sm:text-lg text-gray-500">Balasan Pengaduan ({{ $complaint->responses->count() }})</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Respon Pengaduan -->
                <section class="mb-8">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6">Respon Pengaduan</h2>
                    @if ($complaint->responses && $complaint->responses->isNotEmpty())
                        @foreach ($complaint->responses as $response)
                            @php
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

                                $afterImages = json_decode($response->after_image, true);

                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-500',
                                    'progress' => 'bg-blue-100 text-blue-700 border border-blue-500',
                                    'selesai' => 'bg-green-100 text-green-700 border border-green-500',
                                ];
                                $statusColor =
                                    $statusColors[$response->new_status] ??
                                    'bg-gray-100 text-gray-700 border border-gray-500';
                            @endphp

                            <div
                                class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 shadow transition duration-300 hover:shadow-lg">
                                <div
                                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center border-b pb-3 mb-4">
                                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800">Respons</h3>
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <p class="text-gray-500 text-sm sm:text-base">
                                            <span class="font-bold">Waktu Respon:</span>
                                            {{$response->created_at->format('d M Y H:i')}}
                                        </p>
                                        {{-- Jika ingin menampilkan durasi respon (rentang waktu) gunakan variabel $timeString --}}
                                        <p class="text-gray-500 text-sm sm:text-base">
                                            <span class="font-bold">Durasi Respon:</span> {{ $timeString }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Status Terbaru -->
                                <div class="mt-4 flex items-center">
                                    <p class="text-gray-700 font-semibold mr-2 text-sm sm:text-base">Status Terbaru:</p>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs sm:text-sm font-bold uppercase {{ $statusColor }}">
                                        {{ ucfirst($response->new_status) }}
                                    </span>
                                </div>

                                <!-- Teks Feedback -->
                                <div class="mt-4 p-3 bg-gray-100 border-l-4 border-gray-500 rounded-lg">
                                    <p class="text-gray-700 italic text-sm sm:text-base">"{{ $response->feedback }}"</p>
                                </div>

                                <!-- Menampilkan Gambar Setelah Respon -->
                                @if (!empty($afterImages) && is_array($afterImages))
                                    <div class="mt-4">
                                        <h4 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">Foto Respon</h4>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                            @foreach ($afterImages as $afterImage)
                                                <div
                                                    class="overflow-hidden rounded-xl shadow transition-transform transform hover:scale-105 bg-gray-100">
                                                    <img src="{{ asset('storage/' . $afterImage) }}" alt="Gambar Respon"
                                                        class="w-full h-28 sm:h-32 object-contain p-2 cursor-pointer"
                                                        onclick="openImagesModal('{{ json_encode([$afterImage]) }}')">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600 text-base">Belum ada respon untuk pengaduan ini.</p>
                    @endif
                </section>
            </div>
        </div>
    </div>

    <!-- Modal Detail Gambar -->
    <div id="imagesModal" class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50 hidden"
        onclick="closeImagesModalOnOverlay(event)">
        <div class="bg-white p-4 rounded-lg max-w-3xl w-full mx-4 relative max-h-screen overflow-y-auto">
            <!-- Tombol Close -->
            <button onclick="closeImagesModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 z-10">
                <i class="fa-solid fa-xmark fa-2x"></i>
            </button>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-center">Detail Gambar</h2>
            </div>
            <div id="modalImagesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Thumbnail gambar akan dimuat di sini -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Pastikan Font Awesome dan (jika diperlukan) jQuery sudah dimuat di layout utama -->
    <script>
        // Fungsi untuk membuka modal dan memuat gambar
        function openImagesModal(imagesJson) {
            try {
                const images = JSON.parse(imagesJson);
                const container = document.getElementById('modalImagesContainer');
                container.innerHTML = '';

                if (!Array.isArray(images) || images.length === 0 || images[0] === null) {
                    container.innerHTML = '<p class="text-gray-500 text-center">Tidak ada gambar.</p>';
                    return;
                }

                images.forEach(function(image) {
                    const imageUrl = `{{ asset('storage') }}/${image}`;
                    const imageDiv = document.createElement('div');
                    imageDiv.classList.add('flex', 'flex-col', 'items-center', 'gap-2', 'border', 'p-2', 'rounded',
                        'shadow-sm');

                    const imgEl = document.createElement('img');
                    imgEl.src = imageUrl;
                    imgEl.alt = "Complaint Image";
                    imgEl.classList.add('object-contain', 'w-full', 'h-48');
                    imgEl.setAttribute('loading', 'lazy');

                    const downloadLink = document.createElement('a');
                    downloadLink.href = imageUrl;
                    downloadLink.download = image.split('/').pop();
                    downloadLink.classList.add('flex', 'items-center', 'justify-center', 'bg-green-500',
                        'text-white', 'p-2', 'rounded-full', 'transition', 'hover:bg-green-600');
                    downloadLink.title = "Download Gambar";
                    downloadLink.innerHTML = '<i class="fa-solid fa-download"></i>';

                    imageDiv.appendChild(imgEl);
                    imageDiv.appendChild(downloadLink);
                    container.appendChild(imageDiv);
                });

                document.getElementById('imagesModal').classList.remove('hidden');
            } catch (error) {
                console.error("Gagal memuat gambar:", error);
            }
        }

        function closeImagesModal() {
            document.getElementById('imagesModal').classList.add('hidden');
        }

        function closeImagesModalOnOverlay(event) {
            if (event.target.id === 'imagesModal') {
                closeImagesModal();
            }
        }
    </script>
@endsection
