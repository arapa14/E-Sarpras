@extends('layouts.admin')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        .scroll-container {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

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
            cursor: pointer;
        }

        .action-icon:hover {
            opacity: 0.85;
        }

        .btn-add {
            background-color: #10b981;
            color: #ffffff;
        }

        .btn-add:hover {
            background-color: #059669;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: #ffffff;
        }

        .btn-edit:hover {
            background-color: #d97706;
        }

        .btn-delete {
            background-color: #ef4444;
            color: #ffffff;
        }

        .btn-delete:hover {
            background-color: #dc2626;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h1 class="text-white text-2xl font-bold">Daftar Lokasi</h1>
                <button id="openNewLocationModal"
                    class="btn-add px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring">
                    Tambah Lokasi
                </button>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table id="locations-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-sm">
                                <th class="border px-4 py-2 text-center">No</th>
                                <th class="border px-4 py-2 text-left">Lokasi</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Lokasi -->
    <div id="newLocationModal" class="fixed inset-0 hidden z-50 overflow-y-auto" role="dialog" aria-modal="true"
        aria-labelledby="newLocationModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl sm:max-w-lg w-full relative">
                <form id="newLocationForm">
                    @csrf
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 id="newLocationModalTitle" class="text-lg font-bold text-gray-800">Tambah Lokasi Baru</h5>
                        <button type="button" id="closeNewLocationModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none"
                            aria-label="Tutup">&times;</button>
                    </div>
                    <div class="px-4 py-5">
                        <div>
                            <label for="new_location" class="block text-gray-700 mb-1">Nama Lokasi</label>
                            <input type="text" id="new_location" name="location"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelNewLocationModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit" id="submitNewLocation"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">Simpan
                            Lokasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Lokasi -->
    <div id="editLocationModal" class="fixed inset-0 hidden z-50 overflow-y-auto" role="dialog" aria-modal="true"
        aria-labelledby="editLocationModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl sm:max-w-lg w-full relative">
                <form id="editLocationForm">
                    @csrf
                    @method('PATCH')
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 id="editLocationModalTitle" class="text-lg font-bold text-gray-800">Edit Lokasi</h5>
                        <button type="button" id="closeEditLocationModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none"
                            aria-label="Tutup">&times;</button>
                    </div>
                    <div class="px-4 py-5">
                        <input type="hidden" id="edit_location_id" name="location_id">
                        <div>
                            <label for="edit_location" class="block text-gray-700 mb-1">Nama Lokasi</label>
                            <input type="text" id="edit_location" name="location"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelEditLocationModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit" id="submitEditLocation"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Lokasi -->
    <div id="deleteLocationModal" class="fixed inset-0 hidden z-50 overflow-y-auto" role="dialog" aria-modal="true"
        aria-labelledby="deleteLocationModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl sm:max-w-md w-full relative p-6">
                <h5 id="deleteLocationModalTitle" class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Hapus</h5>
                <p class="mb-6">Apakah Anda yakin akan menghapus lokasi ini?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelDeleteLocationBtn"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                    <button id="confirmDeleteLocationBtn"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none focus:ring">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            var deleteLocationId = null;
            var table = $('#locations-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('location.getLocation') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'location',
                        name: 'location'
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

            // Fungsi spinner
            function showSpinner() {
                $("#loadingOverlay").fadeIn(200);
            }

            function hideSpinner() {
                $("#loadingOverlay").fadeOut(200);
            }

            // Fungsi untuk membuka dan menutup modal
            function openModal(modalId, focusEl) {
                $(modalId).removeClass("hidden").attr("aria-hidden", "false");
                setTimeout(function() {
                    $(focusEl).focus();
                }, 300);
            }

            function closeModal(modalId, restoreFocusEl) {
                $(modalId).addClass("hidden").attr("aria-hidden", "true");
                if (restoreFocusEl) {
                    $(restoreFocusEl).focus();
                }
            }

            // Modal Tambah Lokasi
            $('#openNewLocationModal').on('click', function() {
                openModal("#newLocationModal", "#new_location");
            });
            $("#closeNewLocationModal, #cancelNewLocationModal").on("click", function() {
                closeModal("#newLocationModal", "#openNewLocationModal");
                $('#newLocationForm')[0].reset();
            });
            $('#newLocationForm').on('submit', function(e) {
                e.preventDefault();
                var $submitBtn = $('#submitNewLocation').prop('disabled', true);
                showSpinner();
                $.ajax({
                    url: '/location',
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        closeModal("#newLocationModal", "#openNewLocationModal");
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $('#newLocationForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = "";
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + "<br>";
                            });
                            toastr.error(errorMessages);
                        } else {
                            toastr.error(xhr.responseJSON.message || 'Gagal menyimpan lokasi.');
                        }
                    },
                    complete: function() {
                        hideSpinner();
                        $submitBtn.prop('disabled', false);
                    }
                });
            });

            // Modal Edit Lokasi
            $(document).on('click', '.btn-edit', function() {
                var locationId = $(this).data('id');
                var locationVal = $(this).data('location');
                $('#edit_location_id').val(locationId);
                $('#edit_location').val(locationVal);
                openModal("#editLocationModal", "#edit_location");
            });
            $("#closeEditLocationModal, #cancelEditLocationModal").on("click", function() {
                closeModal("#editLocationModal", "#openNewLocationModal");
                $('#editLocationForm')[0].reset();
            });
            $('#editLocationForm').on('submit', function(e) {
                e.preventDefault();
                var locationId = $('#edit_location_id').val();
                var $submitBtn = $('#submitEditLocation').prop('disabled', true);
                showSpinner();
                $.ajax({
                    url: '/location/' + locationId,
                    type: 'PATCH',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        closeModal("#editLocationModal", "#openNewLocationModal");
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = "";
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + "<br>";
                            });
                            toastr.error(errorMessages);
                        } else {
                            toastr.error(xhr.responseJSON.message ||
                                'Gagal memperbarui lokasi.');
                        }
                    },
                    complete: function() {
                        hideSpinner();
                        $submitBtn.prop('disabled', false);
                    }
                });
            });

            // Hapus Lokasi
            $(document).on('click', '.btn-delete', function() {
                deleteLocationId = $(this).data('id');
                openModal("#deleteLocationModal", "#confirmDeleteLocationBtn");
            });
            $("#cancelDeleteLocationBtn").on("click", function() {
                closeModal("#deleteLocationModal", "#openNewLocationModal");
                deleteLocationId = null;
            });
            $("#confirmDeleteLocationBtn").on("click", function() {
                if (deleteLocationId) {
                    showSpinner();
                    $.ajax({
                        url: '/location/' + deleteLocationId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message || 'Gagal menghapus lokasi.');
                        },
                        complete: function() {
                            hideSpinner();
                            closeModal("#deleteLocationModal", "#openNewLocationModal");
                            deleteLocationId = null;
                        }
                    });
                }
            });
        });
    </script>
@endsection
