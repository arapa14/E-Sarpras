@extends('layouts.user')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@section('content')
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Submit Laporan Komplain</h2>

        @if ($errors->any())
            <div id="error-message" class="p-3 mb-4 text-sm text-red-600 bg-red-100 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div id="success-message" class="p-3 mb-4 text-sm text-green-600 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form id="reportForm" action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="image-upload-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label for="image-1"
                        class="relative border-2 border-dashed border-gray-300 rounded-md hover:border-blue-500 transition-all duration-300 p-4 flex flex-col items-center justify-center cursor-pointer"
                        role="button">
                        <input type="file" name="before_image" id="image-1" accept="image/*" capture="environment"
                            class="hidden" onchange="previewImage(event, 'preview-1')">
                        <div id="default-image-1" class="flex flex-col items-center">
                            <i class="fas fa-camera text-3xl text-gray-500"></i>
                            <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sebelum</p>
                        </div>
                        <img id="preview-1" src="#" alt="Preview Gambar"
                            class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                        <button type="button" class="remove-preview hidden" aria-label="Hapus gambar"
                            onclick="removePreview('image-1', 'preview-1', 'default-image-1')">
                            <i class="fa fa-times"></i>
                        </button>
                    </label>
                </div>
            </div>

            <button type="button" id="addImageButton"
                class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                Tambah Gambar
            </button>

            <div class="mt-4">
                <select name="location" class="w-full p-2 border rounded-md select2">
                    <option value="">Pilih lokasi</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->location }}">{{ $location->location }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <input type="text" name="description" placeholder="Deskripsi" class="w-full p-2 border rounded-md" />
            </div>

            <div class="mt-4">
                <input type="text" name="suggestion" placeholder="Saran perbaikan"
                    class="w-full p-2 border rounded-md" />
            </div>

            <div class="mt-6">
                <button type="submit" id="submitButton"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 w-full">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const defaultContent = input.parentElement.querySelector('div');
            const removeBtn = input.parentElement.querySelector('.remove-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    defaultContent.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview(inputId, previewId, defaultId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const defaultContent = document.getElementById(defaultId);
            const removeBtn = input.parentElement.querySelector('.remove-preview');

            input.value = "";
            preview.src = "#";
            preview.classList.add('hidden');
            defaultContent.classList.remove('hidden');
            removeBtn.classList.add('hidden');
        }
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih lokasi",
                allowClear: true
            });

            $('#reportForm').find('input, select, textarea').on('keydown', function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    var $inputs = $('#reportForm').find('input, select, textarea');
                    var idx = $inputs.index(this);
                    if (idx === $inputs.length - 1) {
                        $('#reportForm').submit();
                    } else {
                        $inputs.eq(idx + 1).focus();
                    }
                }
            });
        });
    </script>
@endsection
