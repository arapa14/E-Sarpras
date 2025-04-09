@extends('layouts.admin')

@section('styles')
    <style>
        .section-title {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f9fafb;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-body {
            padding: 1.5rem;
        }

        .label-title {
            font-weight: 600;
            color: #374151;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Styling untuk field upload gambar */
        .image-upload-field {
            position: relative;
        }

        .image-upload-field label {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .image-upload-field label:hover {
            border-color: #3b82f6;
        }

        .image-upload-field .remove-field {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background-color: #fff;
            border-radius: 9999px;
            padding: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-8 space-y-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Detail Pengaduan -->
        <div class="card">
            <div class="card-header">
                <h1 class="text-3xl font-bold text-gray-800">Detail Pengaduan</h1>
            </div>
            <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informasi Pengaduan -->
                <div class="space-y-3">
                    <h2 class="text-2xl font-semibold text-gray-700">Informasi Pengaduan</h2>
                    <p><span class="label-title">User:</span> {{ $complaint->user->name }}</p>
                    <p><span class="label-title">Deskripsi:</span> {{ $complaint->description }}</p>
                    <p><span class="label-title">Lokasi:</span> {{ $complaint->location }}</p>
                    <p><span class="label-title">Saran:</span> {{ $complaint->suggestion }}</p>
                    <p>
                        <span class="label-title">Waktu:</span>
                        {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y H:i') }}
                    </p>
                    <p>
                        <span class="label-title">Status Saat Ini:</span>
                        <span
                            class="badge
                            @if ($complaint->status == 'pending') bg-yellow-100 text-yellow-700 border border-yellow-500
                            @elseif($complaint->status == 'progress') bg-blue-100 text-blue-700 border border-blue-500
                            @elseif($complaint->status == 'selesai') bg-green-100 text-green-700 border border-green-500
                            @else bg-gray-100 text-gray-600 @endif">
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </p>
                </div>
                <!-- Gambar Sebelum -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Gambar Sebelum</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $beforeImages = json_decode($complaint->before_image, true);
                        @endphp
                        @if ($beforeImages && count($beforeImages) > 0)
                            @foreach ($beforeImages as $image)
                                <div class="overflow-hidden rounded-lg shadow-md bg-gray-100">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar Sebelum"
                                        class="w-full max-h-80 object-contain p-4 cursor-pointer"
                                        onclick="openImagesModal('{{ json_encode([$image]) }}')">
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">Tidak ada gambar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Balasan -->
        @if ($complaint->responses->count())
            <div class="card">
                <div class="card-header">
                    <h2 class="text-2xl font-bold text-gray-800">Riwayat Balasan</h2>
                </div>
                <div class="card-body space-y-6">
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
                                'pending' => 'bg-yellow-100 text-yellow-600',
                                'progress' => 'bg-blue-100 text-blue-600',
                                'selesai' => 'bg-green-100 text-green-600',
                            ];
                            $statusColor = $statusColors[$response->new_status] ?? 'bg-gray-100 text-gray-600';
                        @endphp

                        <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p><span class="label-title">Feedback:</span> <span
                                            class="text-gray-700">{{ $response->feedback }}</span></p>
                                    <p>
                                        <span class="label-title">Status Baru:</span>
                                        <span class="badge {{ $statusColor }}">
                                            {{ ucfirst($response->new_status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="space-y-2 text-right">
                                    <p>
                                        <span class="label-title">Waktu Dibalas:</span>
                                        <span class="text-gray-700">
                                            {{ \Carbon\Carbon::parse($response->created_at)->format('d M Y H:i') }}
                                        </span>
                                    </p>
                                    <p>
                                        <span class="label-title">Response Time:</span>
                                        <span class="text-gray-700">{{ $timeString }}</span>
                                    </p>
                                </div>
                            </div>
                            @if ($afterImages && count($afterImages) > 0)
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($afterImages as $img)
                                        <div class="overflow-hidden rounded-lg shadow-md bg-white">
                                            <img src="{{ asset('storage/' . $img) }}" alt="Gambar Sesudah"
                                                class="w-full max-h-60 object-contain p-2 cursor-pointer"
                                                onclick="openImagesModal('{{ json_encode([$img]) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Form Balasan Pengaduan -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-2xl font-bold text-gray-800">Balas Pengaduan</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('response.store', $complaint->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6" id="reportForm">
                    @csrf
                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="5" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="{{ old('feedback', $complaint->responses->last()->feedback ?? 'Berikan feedback') }}"></textarea>
                    </div>

                    <!-- Upload Gambar Sesudah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sesudah</label>
                        <div id="after-image-upload-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="image-upload-field">
                                <label for="after-image-1" class="relative group block">
                                    <input type="file" name="after_image[]" id="after-image-1" accept="image/*"
                                        class="hidden"
                                        onchange="previewImage(event, 'after-preview-1', 'after-default-image-1')">
                                    <div id="after-default-image-1"
                                        class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg group-hover:border-blue-500 transition-all">
                                        <i class="fas fa-camera text-3xl text-gray-500"></i>
                                        <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sesudah
                                        </p>
                                    </div>
                                    <img id="after-preview-1" src="#" alt="Preview Gambar Sesudah"
                                        class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                                    <button type="button"
                                        class="remove-field absolute top-2 right-2 bg-white rounded-full p-1 shadow hidden group-hover:block"
                                        onclick="removeImageField('after-image-1')">
                                        <i class="fa fa-times text-red-500"></i>
                                    </button>
                                </label>
                            </div>
                        </div>
                        <button type="button" id="addAfterImageButton"
                            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Tambah Gambar Sesudah
                        </button>
                    </div>

                    <!-- Ubah Status Pengaduan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Pengaduan</label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5 text-yellow-600" name="status"
                                    value="pending"
                                    {{ isset($complaint->responses) && $complaint->responses->first() && $complaint->responses->first()->new_status == 'pending' ? 'checked' : ($complaint->status == 'pending' ? 'checked' : '') }}>
                                <span
                                    class="ml-2 badge bg-yellow-100 text-yellow-700 border border-yellow-500">Pending</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5 text-blue-600" name="status"
                                    value="progress"
                                    {{ isset($complaint->responses) && $complaint->responses->first() && $complaint->responses->first()->new_status == 'progress' ? 'checked' : ($complaint->status == 'progress' ? 'checked' : '') }}>
                                <span class="ml-2 badge bg-blue-100 text-blue-700 border border-blue-500">Progress</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5 text-green-600" name="status"
                                    value="selesai"
                                    {{ isset($complaint->responses) && $complaint->responses->first() && $complaint->responses->first()->new_status == 'selesai' ? 'checked' : ($complaint->status == 'selesai' ? 'checked' : '') }}>
                                <span class="ml-2 badge bg-green-100 text-green-700 border border-green-500">Selesai</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                            Kirim Balasan
                        </button>
                    </div>
                </form>
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
    <script>
        // Penghitung ID unik untuk field upload gambar, mulai dari 2 karena field pertama sudah ada
        let imageCounter = 2;

        // Event untuk tombol "Tambah Gambar Sesudah"
        $('#addAfterImageButton').on('click', function() {
            let inputId = 'after-image-' + imageCounter;
            let previewId = 'after-preview-' + imageCounter;
            let defaultId = 'after-default-image-' + imageCounter;

            let newField = `
                <div class="image-upload-field">
                    <label for="${inputId}" class="relative group block">
                        <input type="file" name="after_image[]" id="${inputId}" accept="image/*"
                            class="hidden" onchange="previewImage(event, '${previewId}', '${defaultId}')">
                        <div id="${defaultId}" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg group-hover:border-blue-500 transition-all">
                            <i class="fas fa-camera text-3xl text-gray-500"></i>
                            <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sesudah</p>
                        </div>
                        <img id="${previewId}" src="#" alt="Preview Gambar Sesudah"
                            class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                        <button type="button" class="remove-field absolute top-2 right-2 bg-white rounded-full p-1 shadow"
                            onclick="removeImageField('${inputId}')">
                            <i class="fa fa-times text-red-500"></i>
                        </button>
                    </label>
                </div>
            `;
            // Append new field ke container yang benar: after-image-upload-container
            $('#after-image-upload-container').append(newField);
            imageCounter++;
        });

        // Tambahkan event untuk memanggil lazy loading ketika form disubmit (contoh: menampilkan spinner)
        $('#reportForm').on('submit', function() {
            showSpinner();
        });

        // Fungsi untuk menampilkan preview gambar dan menyembunyikan konten default
        function previewImage(event, previewId, defaultId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const defaultContent = document.getElementById(defaultId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    defaultContent.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Fungsi untuk menghapus field upload gambar
        function removeImageField(inputId) {
            const field = document.getElementById(inputId).closest('.image-upload-field');
            field.remove();
        }

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
                    imgEl.alt = "Detail Gambar";
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
