@extends('layouts.admin')

@section('styles')
    <style>
        .section-title {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
        }

        /* Styling untuk dropdown (saat terbuka) */
        select option[value="pending"] {
            background-color: #fef3c7;
            color: #92400e;
        }

        select option[value="progress"] {
            background-color: #dbeafe;
            color: #1e3a8a;
        }

        select option[value="selesai"] {
            background-color: #d1fae5;
            color: #065f46;
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
    <div class="max-w-7xl mx-auto p-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
            <!-- Detail Pengaduan -->
            <div class="p-8 border-b">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Pengaduan</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informasi Pengaduan -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Pengaduan</h2>
                        <p class="mb-2"><span class="font-bold">User:</span> {{ $complaint->user->name }}</p>
                        <p class="mb-2"><span class="font-bold">Deskripsi:</span> {{ $complaint->description }}</p>
                        <p class="mb-2"><span class="font-bold">Lokasi:</span> {{ $complaint->location }}</p>
                        <p class="mb-2"><span class="font-bold">Saran:</span> {{ $complaint->suggestion }}</p>
                        <p class="mb-2">
                            <span class="font-bold">Waktu:</span>
                            {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y H:i') }}
                        </p>
                        <p class="mb-2">
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
                    </div>
                    <!-- Gambar Sebelum -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Gambar Sebelum</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                $beforeImages = json_decode($complaint->before_image, true);
                            @endphp
                            @if ($beforeImages && count($beforeImages) > 0)
                                @foreach ($beforeImages as $image)
                                    <div class="overflow-hidden rounded-lg shadow-lg bg-gray-100">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Gambar Sebelum"
                                            class="w-full max-h-80 object-contain p-4">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Tidak ada gambar.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Balasan Pengaduan -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 section-title">Balas Pengaduan</h2>
                <form action="{{ route('response.store', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="5" required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Ganti field input gambar sesudah dengan fitur unggah gambar -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sesudah (Opsional)</label>
                        <div id="after-image-upload-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Field upload gambar pertama -->
                            <div class="image-upload-field">
                                <label for="after-image-1"
                                    class="relative border-2 border-dashed border-gray-300 rounded-md hover:border-blue-500 transition-all duration-300 p-4 flex flex-col items-center justify-center cursor-pointer"
                                    role="button">
                                    <input type="file" name="after_image[]" id="after-image-1" accept="image/*"
                                        class="hidden"
                                        onchange="previewImage(event, 'after-preview-1', 'after-default-image-1')">
                                    <div id="after-default-image-1" class="flex flex-col items-center">
                                        <i class="fas fa-camera text-3xl text-gray-500"></i>
                                        <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sesudah
                                        </p>
                                    </div>
                                    <img id="after-preview-1" src="#" alt="Preview Gambar Sesudah"
                                        class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                                    <button type="button"
                                        class="remove-field absolute top-2 right-2 bg-white rounded-full p-1 shadow"
                                        onclick="removeImageField('after-image-1')">
                                        <i class="fa fa-times text-red-500"></i>
                                    </button>
                                </label>
                            </div>
                        </div>
                        <button type="button" id="addAfterImageButton"
                            class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                            Tambah Gambar Sesudah
                        </button>
                    </div>

                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Ubah Status
                            Pengaduan</label>
                        <select id="status" name="status"
                            class="w-full border border-gray-300 rounded-lg p-3 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="progress" {{ $complaint->status == 'progress' ? 'selected' : '' }}>Progress
                            </option>
                            <option value="selesai" {{ $complaint->status == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
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
@endsection

@section('scripts')
    <script>
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

        // Tambahkan fungsi untuk menambah field upload gambar sesudah
        let afterImageCounter = 2;
        document.getElementById('addAfterImageButton').addEventListener('click', function() {
            let inputId = 'after-image-' + afterImageCounter;
            let previewId = 'after-preview-' + afterImageCounter;
            let defaultId = 'after-default-image-' + afterImageCounter;

            let newField = `
                <div class="image-upload-field">
                    <label for="${inputId}"
                        class="relative border-2 border-dashed border-gray-300 rounded-md hover:border-blue-500 transition-all duration-300 p-4 flex flex-col items-center justify-center cursor-pointer"
                        role="button">
                        <input type="file" name="after_image[]" id="${inputId}" accept="image/*" class="hidden" onchange="previewImage(event, '${previewId}', '${defaultId}')">
                        <div id="${defaultId}" class="flex flex-col items-center">
                            <i class="fas fa-camera text-3xl text-gray-500"></i>
                            <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sesudah</p>
                        </div>
                        <img id="${previewId}" src="#" alt="Preview Gambar Sesudah"
                             class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                        <button type="button" class="remove-field absolute top-2 right-2 bg-white rounded-full p-1 shadow" onclick="removeImageField('${inputId}')">
                            <i class="fa fa-times text-red-500"></i>
                        </button>
                    </label>
                </div>
            `;
            document.getElementById('after-image-upload-container').insertAdjacentHTML('beforeend', newField);
            afterImageCounter++;
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('status');

            function updateSelectStyle() {
                const value = selectElement.value;
                if (value === 'pending') {
                    selectElement.style.backgroundColor = "#fef3c7";
                    selectElement.style.color = "#92400e";
                } else if (value === 'progress') {
                    selectElement.style.backgroundColor = "#dbeafe";
                    selectElement.style.color = "#1e3a8a";
                } else if (value === 'selesai') {
                    selectElement.style.backgroundColor = "#d1fae5";
                    selectElement.style.color = "#065f46";
                } else {
                    selectElement.style.backgroundColor = "#ffffff";
                    selectElement.style.color = "#000000";
                }
            }
            selectElement.addEventListener('change', updateSelectStyle);
            updateSelectStyle();
        });
    </script>
@endsection
