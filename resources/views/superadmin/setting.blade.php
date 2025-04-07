@extends('layouts.admin')

@section('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        .card {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .transition-all {
            transition: all 0.3s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-semibold text-blue-800">⚙️ Pengaturan Sistem</h1>
        </div>

        <form id="systemSettingForm" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PATCH')

            {{-- Nama Sistem --}}
            <div>
                <label for="name" class="block text-lg font-medium text-gray-800 mb-2">Nama Sistem</label>
                <input type="text" name="name" id="name" placeholder="{{ $settings['name'] ?? '' }}"
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm text-gray-600 mt-1">Nama saat ini:
                    <strong>{{ $settings['name'] ?? 'Belum diatur' }}</strong></p>
            </div>

            {{-- Upload Komponen --}}
            @php
                $uploadFields = [
                    ['label' => 'Logo Sistem', 'key' => 'logo'],
                    ['label' => 'Main Image', 'key' => 'main_image'],
                ];
            @endphp

            @foreach ($uploadFields as $field)
                <div>
                    <label class="block text-lg font-medium text-gray-800 mb-3">{{ $field['label'] }}</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Gambar Saat Ini --}}
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Gambar saat ini</p>
                            @if (isset($settings[$field['key']]) && $settings[$field['key']])
                                <div class="border rounded-md p-2 bg-gray-50">
                                    <img src="{{ asset($settings[$field['key']]) }}" alt="{{ $field['label'] }}"
                                        class="w-32 h-auto mx-auto">
                                </div>
                            @else
                                <div
                                    class="border p-4 rounded-md flex items-center justify-center text-gray-400 bg-gray-50 h-32">
                                    <span>Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>

                        {{-- Upload Baru --}}
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Gambar baru</p>
                            <div
                                class="relative border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 transition-all p-6 text-center cursor-pointer">
                                <input type="file" name="{{ $field['key'] }}" id="{{ $field['key'] }}" accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(event, '{{ $field['key'] }}Preview', 'default{{ ucfirst($field['key']) }}Text')">
                                <div id="default{{ ucfirst($field['key']) }}Text">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <p class="mt-2 text-gray-600">Klik atau seret file ke sini</p>
                                </div>
                                <img id="{{ $field['key'] }}Preview" src="#" alt="Preview"
                                    class="mt-4 hidden w-full h-48 object-contain rounded-lg">
                                <button type="button"
                                    class="remove-field absolute top-2 right-2 bg-white rounded-full p-1 shadow"
                                    onclick="clearPreview('{{ $field['key'] }}', '{{ $field['key'] }}Preview', 'default{{ ucfirst($field['key']) }}Text')">
                                    <i class="fa fa-times text-red-500"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button type="button" onclick="showConfirmModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition-all">
                    💾 Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    {{-- Modal Konfirmasi --}}
    <div id="confirmSettingModal" class="fixed inset-0 hidden z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-40" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl sm:max-w-md w-full relative p-6 z-50">
                <h5 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Simpan</h5>
                <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menyimpan perubahan pengaturan?</p>
                <div class="flex justify-end space-x-3">
                    <button onclick="hideConfirmModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button onclick="submitForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ya,
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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

        function showConfirmModal() {
            document.getElementById('confirmSettingModal').classList.remove('hidden');
        }

        function hideConfirmModal() {
            document.getElementById('confirmSettingModal').classList.add('hidden');
        }

        function submitForm() {
            hideConfirmModal();
            $('#systemSettingForm').submit();
        }

        // AJAX Submit
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
