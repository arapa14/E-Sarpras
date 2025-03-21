<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/png" href="{{ asset($logo) }}" />
    <title>{{ $apk }}</title>
    @vite('resources/css/app.css')
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Container Utama -->
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col sm:flex-row justify-between items-center">
            <!-- Nama Pengguna -->
            <h1 class="text-xl font-bold text-blue-600 mb-2 sm:mb-0">
                Welcome, {{ $user->name }}
            </h1>

            <!-- Jam (Real-time) -->
            <span id="realTimeClock" class="text-gray-600 mb-2 sm:mb-0">
                Memuat Waktu...
            </span>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                    class="flex items-center text-red-600 hover:text-red-800 text-lg w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 17l5-5-5-5M21 12H9m4-7v14"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

        <!-- Tombol Navigasi -->
        <div class="flex flex-col sm:flex-row gap-4 mt-6">
            <a href="#" class="btn-primary text-white px-6 py-2 rounded-lg w-full sm:w-auto text-center">
                Lihat Riwayat
            </a>
            <a href="#" class="btn-secondary text-white px-6 py-2 rounded-lg w-full sm:w-auto text-center">
                Buat Komplain
            </a>
        </div>

        <!-- Form Laporan Komplain -->
        <div class="mt-6 bg-white shadow-md rounded-lg p-6">
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

            <!-- Ubah action sesuai route untuk menyimpan data komplain -->
            <form id="reportForm" action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Input Gambar Sebelum (before_image) -->
                <div id="image-upload-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label for="image-1"
                            class="relative border-2 border-dashed border-gray-300 rounded-md hover:border-blue-500 transition-all duration-300 p-4 flex flex-col items-center justify-center cursor-pointer"
                            role="button">
                            <input type="file" name="before_image" id="image-1" accept="image/*"
                                capture="environment" class="hidden" onchange="previewImage(event, 'preview-1')">
                            <div id="default-image-1" class="flex flex-col items-center">
                                <i class="fas fa-camera text-3xl text-gray-500"></i>
                                <p class="mt-2 text-gray-600 text-center">Klik atau tap untuk upload gambar sebelum</p>
                            </div>
                            <img id="preview-1" src="#" alt="Preview Gambar"
                                class="mt-2 hidden object-cover w-full h-48 rounded-md transition-all duration-300 ease-in-out">
                            <button type="button" class="remove-preview hidden"
                                onclick="removePreview(event, 'image-1', 'preview-1', 'default-image-1')">
                                <i class="fa fa-times"></i>
                            </button>
                        </label>
                    </div>
                </div>

                <!-- Tombol untuk menambah input gambar tambahan (jika diperlukan) -->
                <button type="button" id="addImageButton"
                    class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-all duration-300">
                    Tambah Gambar
                </button>

                <!-- Input Lokasi -->
                <div class="mt-4">
                    <select name="location" class="w-full p-2 border rounded-md select2">
                        <option value="">Pilih lokasi</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Deskripsi -->
                <div class="mt-4">
                    <input type="text" name="description" placeholder="Deskripsi"
                        class="w-full p-2 border rounded-md" />
                </div>

                <!-- Input Saran (suggestion) -->
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
    </div>

    <!-- Script -->
    <script>
        // Fungsi previewImage: menampilkan preview gambar setelah memilih file
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            const defaultContent = input.parentElement.querySelector('div');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    defaultContent.classList.add('hidden');
                    const removeBtn = input.parentElement.querySelector('.remove-preview');
                    if (removeBtn) removeBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Fungsi removePreview: menghapus preview gambar dan mengembalikan tampilan awal
        function removePreview(event, inputId, previewId, defaultId) {
            event.stopPropagation();
            event.preventDefault();
            const uploadWrapper = event.currentTarget.closest('div');
            if (uploadWrapper) {
                uploadWrapper.remove();
            }
        }

        // Fungsi updateClock untuk mengambil dan menampilkan waktu server secara real-time
        function updateClock() {
            fetch('/server-time')
                .then(response => response.json())
                .then(data => {
                    const serverTime = new Date(data.time);
                    const hours = serverTime.getHours().toString().padStart(2, '0');
                    const minutes = serverTime.getMinutes().toString().padStart(2, '0');
                    const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                        "September", "Oktober", "November", "Desember"
                    ];
                    const dayName = days[serverTime.getDay()];
                    const day = serverTime.getDate();
                    const month = months[serverTime.getMonth()];
                    const year = serverTime.getFullYear();
                    document.getElementById('realTimeClock').innerText =
                        `${dayName}, ${day} ${month} ${year} - ${hours}:${minutes}`;
                })
                .catch(error => console.error("Gagal mengambil waktu server:", error));
        }
        updateClock();
        setInterval(updateClock, 30000);

        // Hapus notifikasi (error/success) setelah 5 detik
        setTimeout(function() {
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            if (errorMessage) {
                errorMessage.style.transition = "opacity 0.5s";
                errorMessage.style.opacity = "0";
                setTimeout(() => errorMessage.remove(), 500);
            }
            if (successMessage) {
                successMessage.style.transition = "opacity 0.5s";
                successMessage.style.opacity = "0";
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 5000);
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: "Pilih lokasi",
                allowClear: true
            });

            // Event listener untuk pindah fokus di dalam form
            $('#reportForm').find('input, select, textarea').on('keydown', function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    var $inputs = $('#reportForm').find('input, select, textarea');
                    var idx = $inputs.index(this);
                    if (idx === $inputs.length - 1) {
                        // Submit form, yang akan menggunakan metode POST
                        $('#reportForm').submit();
                    } else {
                        // Pindah fokus ke field berikutnya
                        $inputs.eq(idx + 1).focus();
                    }
                }
            });
        });
    </script>


</body>

</html>
