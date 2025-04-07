@extends('layouts.admin')

@section('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- AlpineJS (untuk modal) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <style>
        /* Custom scrollbar (opsional) */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <div x-data="{ showModal: false }">
        <!-- Form dan tombol simpan -->
        <div class="min-h-screen bg-gray-50 py-12">
            <!-- Container responsif dengan padding mobile -->
            <div class="container mx-auto px-4 lg:px-12">
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                    <!-- Header dengan background gradasi -->
                    <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-10">
                        <h1 class="text-4xl font-bold text-white flex items-center gap-3">
                            <i class="fas fa-cogs"></i>
                            Pengaturan Sistem
                        </h1>
                        <p class="mt-3 text-blue-100 text-lg">
                            Atur dan sesuaikan sistem Anda dengan antarmuka yang responsif dan modern.
                        </p>
                    </div>
                    <!-- Konten Form -->
                    <div class="p-6 lg:p-10">
                        <form id="systemSettingForm" action="{{ route('setting.update') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            @method('PATCH')

                            <!-- Bagian Nama Sistem -->
                            <div>
                                <label for="name" class="block text-2xl font-medium text-gray-700 mb-3">
                                    Nama Sistem
                                </label>
                                <input type="text" name="name" id="name"
                                    placeholder="{{ $settings['name'] ?? '' }}"
                                    class="w-full px-5 py-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg">
                                <p class="text-md text-gray-500 mt-2">
                                    Nama saat ini: <strong>{{ $settings['name'] ?? 'Belum diatur' }}</strong>
                                </p>
                            </div>

                            <!-- Bagian Upload Gambar -->
                            @php
                                $uploadFields = [
                                    ['label' => 'Logo Sistem', 'key' => 'logo'],
                                    ['label' => 'Main Image', 'key' => 'main_image'],
                                ];
                            @endphp

                            @foreach ($uploadFields as $field)
                                <div class="border-t pt-8">
                                    <label class="block text-2xl font-medium text-gray-700 mb-4">
                                        {{ $field['label'] }}
                                    </label>
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <!-- Preview Gambar Saat Ini -->
                                        <div>
                                            <p class="text-md text-gray-500 mb-3">Gambar saat ini</p>
                                            @if (isset($settings[$field['key']]) && $settings[$field['key']])
                                                <div class="border rounded-md p-4 bg-gray-50">
                                                    <img src="{{ asset($settings[$field['key']]) }}"
                                                        alt="{{ $field['label'] }}" class="w-40 h-auto mx-auto">
                                                </div>
                                            @else
                                                <div
                                                    class="border p-6 rounded-md flex items-center justify-center text-gray-400 bg-gray-50 h-40">
                                                    <span>Tidak ada gambar</span>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Upload Gambar Baru -->
                                        <div>
                                            <p class="text-md text-gray-500 mb-3">Gambar baru</p>
                                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition-all p-10 text-center cursor-pointer"
                                                onclick="document.getElementById('{{ $field['key'] }}').click()">
                                                <input type="file" name="{{ $field['key'] }}" id="{{ $field['key'] }}"
                                                    accept="image/*" class="hidden"
                                                    onchange="previewImage(event, '{{ $field['key'] }}Preview', 'default{{ ucfirst($field['key']) }}Text')">
                                                <div id="default{{ ucfirst($field['key']) }}Text">
                                                    <i class="fas fa-cloud-upload-alt text-6xl text-gray-400"></i>
                                                    <p class="mt-5 text-xl text-gray-600">Klik atau seret file ke sini</p>
                                                </div>
                                                <img id="{{ $field['key'] }}Preview" src="#" alt="Preview"
                                                    class="mt-6 hidden w-full h-56 object-contain rounded-lg">
                                                <button type="button"
                                                    class="remove-field absolute top-4 right-4 bg-white rounded-full p-2 shadow hover:bg-gray-100"
                                                    onclick="clearPreview('{{ $field['key'] }}', '{{ $field['key'] }}Preview', 'default{{ ucfirst($field['key']) }}Text'); event.stopPropagation();">
                                                    <i class="fa fa-times text-red-500"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Tombol Simpan -->
                            <div class="flex justify-end">
                                <button type="button" @click="showModal = true"
                                    class="w-full sm:w-auto flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition-all text-lg">
                                    <i class="fas fa-save"></i>
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Menggunakan AlpineJS -->
        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50"
            style="background: rgba(0,0,0,0.6);" x-cloak>
            <div class="bg-white rounded-lg shadow-2xl w-11/12 md:max-w-lg mx-auto p-8">
                <h5 class="text-2xl font-semibold text-gray-800 mb-6">Konfirmasi Simpan</h5>
                <p class="mb-8 text-gray-600 text-lg">Apakah Anda yakin ingin menyimpan perubahan pengaturan?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showModal = false"
                        class="bg-gray-500 text-white px-6 py-3 rounded-md hover:bg-gray-600 text-lg">Batal</button>
                    <button @click="$nextTick(() => { $('#systemSettingForm').trigger('submit'); })"
                        class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 text-lg">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewImage(event, previewId, defaultTextId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const defaultText = document.getElementById(defaultTextId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    defaultText.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearPreview(inputId, previewId, defaultTextId) {
            document.getElementById(inputId).value = "";
            const preview = document.getElementById(previewId);
            preview.src = "#";
            preview.classList.add('hidden');
            document.getElementById(defaultTextId).classList.remove('hidden');
        }

        // Fungsi spinner
        function showSpinner() {
            $("#loadingOverlay").fadeIn(200);
        }

        function hideSpinner() {
            $("#loadingOverlay").fadeOut(200);
        }

        // AJAX submit
        $('#systemSettingForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            showSpinner();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.updated) {
                        hideSpinner();
                        toastr.success(response.message);
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        toastr.info(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = "";
                        $.each(errors, function(key, value) {
                            errorMessages += value[0] + "<br>";
                        });
                        toastr.error(errorMessages);
                    } else {
                        toastr.error(xhr.responseJSON.message || 'Gagal menyimpan pengaturan.');
                    }
                },
                complete: function() {
                    hideSpinner();
                }
            });
        });
    </script>
@endsection
