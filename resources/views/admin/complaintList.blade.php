@extends('layouts.admin')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Buat container khusus untuk tabel dengan scroll horizontal */
        .scroll-container {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            /* agar lebih smooth pada mobile */
        }

        /* Custom styling untuk DataTables agar selaras dengan Tailwind */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: #e5e7eb;
            color: #374151 !important;
            margin: 0 0.125rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #d1d5db;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            outline: none;
        }

        table.dataTable thead {
            background-color: #f3f4f6;
        }

        table.dataTable thead th {
            color: #374151;
            font-weight: 600;
        }

        /* Styling untuk ikon aksi */
        .action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 9999px;
            transition: background-color 0.3s;
        }

        .action-icon:hover {
            opacity: 0.85;
        }

        .btn-view {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .btn-download {
            background-color: #10b981;
            color: #ffffff;
        }

        .btn-detail {
            background-color: #2563eb;
            /* Warna biru yang sedikit berbeda dari btn-view */
            color: #ffffff;
        }

        .btn-detail:hover {
            background-color: #1d4ed8;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-white text-2xl font-bold">Daftar Pengaduan</h1>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table id="complaints-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-sm">
                                <th class="border px-4 py-2 text-center">No</th>
                                <th class="border px-4 py-2 text-center">Nama User</th>
                                <th class="border px-4 py-2 text-left">Deskripsi</th>
                                <th class="border px-4 py-2 text-left">Lokasi</th>
                                <th class="border px-4 py-2 text-left">Saran</th>
                                <th class="border px-4 py-2 text-left">Waktu</th>
                                <th class="border px-4 py-2 text-center">Status</th>
                                <th class="border px-4 py-2 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Gambar (sama seperti sebelumnya) -->
    <div id="imagesModal" class="fixed inset-0 bg-gray-800/75 flex items-center justify-center z-50 hidden"
        onclick="closeImagesModalOnOverlay(event)">
        <div class="bg-white p-4 rounded-lg max-w-3xl w-full mx-4 relative max-h-screen overflow-y-auto">
            <button onclick="closeImagesModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 z-10">
                <i class="fa-solid fa-xmark fa-2x"></i>
            </button>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-center">Detail Gambar</h2>
            </div>
            <div id="modalImagesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#complaints-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('complaint.getList') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user.name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'suggestion',
                        name: 'suggestion'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Loading...'
                }
            });

            // Event handler untuk update status lewat dropdown
            $(document).on('change', '.status-dropdown', function() {
                var complaintId = $(this).data('id');
                var status = $(this).val();

                $.ajax({
                    url: '/pengaduan/' + complaintId + '/status',
                    type: 'PATCH',
                    data: {
                        status: status
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        // Opsional: reload table agar data terbaru terlihat
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        toastr.error('Gagal memperbarui status.');
                    }
                });
            });
        });
    </script>

    <!-- Script Modal Detail Gambar (sama seperti sebelumnya) -->
    <script>
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
