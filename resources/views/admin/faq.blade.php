@extends('layouts.admin')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        /* Custom styling untuk DataTables */
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

        .btn-detail {
            background-color: #2563eb;
            color: #ffffff;
        }

        .btn-detail:hover {
            background-color: #1d4ed8;
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
    <div class="container mx-auto px-4 py-6 space-y-10">
        <!-- Tabel Pertanyaan -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-white text-xl sm:text-2xl font-bold">Daftar Pertanyaan</h1>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table id="questions-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-xs sm:text-sm">
                                <th class="border px-4 py-2 text-center">No</th>
                                <th class="border px-4 py-2 text-center">Pertanyaan</th>
                                <th class="border px-4 py-2 text-left">Waktu</th>
                                <th class="border px-4 py-2 text-center">Status</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel FAQ -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h1 class="text-white text-xl sm:text-2xl font-bold">Daftar FAQ</h1>
            </div>
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                    <h2 class="text-gray-700 text-lg font-medium mb-2 sm:mb-0">Kelola FAQ</h2>
                    <button id="openNewFaqModal"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring">
                        Tambah FAQ
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table id="faq-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-xs sm:text-sm">
                                <th class="border px-4 py-2 text-center">No</th>
                                <th class="border px-4 py-2 text-center">Pertanyaan</th>
                                <th class="border px-4 py-2 text-center">Jawaban</th>
                                <th class="border px-4 py-2 text-center">Status</th>
                                <th class="border px-4 py-2 text-center">Waktu</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah FAQ Baru -->
    <div id="newFaqModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full relative">
                <form id="newFaqForm">
                    @csrf
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 class="text-lg font-bold text-gray-800">Tambah FAQ Baru</h5>
                        <button type="button" id="closeNewFaqModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none">&times;</button>
                    </div>
                    <div class="px-4 py-5 space-y-4">
                        <div>
                            <label for="new_faq_question" class="block text-gray-700 mb-1">Pertanyaan</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                id="new_faq_question" name="question" rows="2" required></textarea>
                        </div>
                        <div>
                            <label for="new_faq_answer" class="block text-gray-700 mb-1">Jawaban</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                id="new_faq_answer" name="answer" rows="3" required></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Status</label>
                            <div class="flex items-center space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="draft" class="form-radio text-gray-600"
                                        required>
                                    <span class="ml-2 text-gray-700">Draft</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="published" class="form-radio text-green-600"
                                        required>
                                    <span class="ml-2 text-green-700">Published</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelNewFaqModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">Simpan
                            FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit FAQ -->
    <div id="editFaqModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full relative">
                <form id="editFaqForm">
                    @csrf
                    @method('PATCH')
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 class="text-lg font-bold text-gray-800">Edit FAQ</h5>
                        <button type="button" id="closeModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none">&times;</button>
                    </div>
                    <div class="px-4 py-5 space-y-4">
                        <input type="hidden" id="faq_id" name="faq_id">
                        <div>
                            <label for="faq_question" class="block text-gray-700 mb-1">Pertanyaan</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="faq_question"
                                name="question" rows="2" required></textarea>
                        </div>
                        <div>
                            <label for="faq_answer" class="block text-gray-700 mb-1">Jawaban</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="faq_answer"
                                name="answer" rows="3" required></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Status</label>
                            <div class="flex items-center space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="draft" class="form-radio text-gray-600"
                                        required>
                                    <span class="ml-2 text-gray-700">Draft</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="published"
                                        class="form-radio text-green-600" required>
                                    <span class="ml-2 text-green-700">Published</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete FAQ -->
    <div id="deleteFaqModal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow-xl sm:max-w-md w-full relative">
                <div class="px-4 py-3 border-b">
                    <h5 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h5>
                </div>
                <div class="px-4 py-5">
                    <p class="text-gray-700">Apakah Anda yakin akan menghapus FAQ ini?</p>
                </div>
                <div class="px-4 py-3 border-t flex justify-end space-x-2">
                    <button type="button" id="cancelDeleteFaq"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none">Batal</button>
                    <button type="button" id="confirmDeleteFaq"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS (untuk modal) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Variabel untuk menyimpan id FAQ yang akan dihapus
        var deleteFaqId = null;

        $(document).ready(function() {

            // Inisialisasi DataTable untuk pertanyaan
            var questionsTable = $('#questions-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('question.getQuestion') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question',
                        name: 'question'
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

            // Inisialisasi DataTable untuk FAQ
            var faqTable = $('#faq-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('faq.getFaq') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer',
                        name: 'answer'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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

            // Fungsi bawaan spinner (sesuaikan implementasi fungsi Anda)
            function showSpinner() {
                // contoh implementasi, misalnya aktifkan overlay loading
                console.log('Show spinner');
            }

            function hideSpinner() {
                console.log('Hide spinner');
            }

            // Buka modal tambah FAQ
            $(document).on('click', '#openNewFaqModal', function() {
                $("#newFaqModal").removeClass("hidden");
            });

            // Tutup modal tambah FAQ
            $("#closeNewFaqModal, #cancelNewFaqModal").on("click", function() {
                $("#newFaqModal").addClass("hidden");
            });

            // Submit form tambah FAQ via Ajax dengan spinner
            $('#newFaqForm').on('submit', function(e) {
                e.preventDefault();
                showSpinner();
                var formData = $(this).serialize();
                $.ajax({
                    url: '/faq',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideSpinner();
                        $("#newFaqModal").addClass("hidden");
                        toastr.success(response.message);
                        $('#faq-table').DataTable().ajax.reload(null, false);
                        $('#newFaqForm')[0].reset();
                    },
                    error: function(xhr) {
                        hideSpinner();
                        toastr.error('Gagal menyimpan FAQ baru.');
                    }
                });
            });

            // Handler untuk change status (dropdown di tabel FAQ) dengan spinner
            $(document).on('change', '.faq-status-dropdown', function() {
                var faqId = $(this).data('id');
                var status = $(this).val();
                var dropdown = $(this);
                showSpinner();
                $.ajax({
                    url: '/faq/' + faqId + '/status',
                    type: 'PATCH',
                    data: {
                        status: status
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideSpinner();
                        var selectedOption = dropdown.find('option:selected').data('class');
                        dropdown.removeClass().addClass(
                            'faq-status-dropdown border border-gray-300 rounded p-1 ' +
                            selectedOption);
                        toastr.success(response.message);
                        faqTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        hideSpinner();
                        toastr.error('Gagal memperbarui status.');
                    }
                });
            });

            // Handler untuk tombol delete FAQ (buka modal delete)
            $(document).on('click', '.btn-delete', function() {
                deleteFaqId = $(this).data('id');
                $("#deleteFaqModal").removeClass("hidden");
            });

            // Batal delete FAQ
            $("#cancelDeleteFaq").on("click", function() {
                deleteFaqId = null;
                $("#deleteFaqModal").addClass("hidden");
            });

            // Konfirmasi delete FAQ dengan spinner
            $("#confirmDeleteFaq").on("click", function() {
                if (deleteFaqId) {
                    showSpinner();
                    $.ajax({
                        url: '/faq/' + deleteFaqId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            hideSpinner();
                            toastr.success(response.message);
                            faqTable.ajax.reload(null, false);
                            $("#deleteFaqModal").addClass("hidden");
                            deleteFaqId = null;
                        },
                        error: function(xhr) {
                            hideSpinner();
                            toastr.error('Gagal menghapus FAQ.');
                        }
                    });
                }
            });

            // Tampilkan modal edit FAQ
            $(document).on('click', '.btn-edit', function() {
                var faqId = $(this).data('id');
                var question = $(this).data('question');
                var answer = $(this).data('answer');
                var status = $(this).data('status');
                $('#faq_id').val(faqId);
                $('#faq_question').val(question);
                $('#faq_answer').val(answer);
                // Set status radio yang sesuai
                $('#editFaqForm input[name="status"]').each(function() {
                    $(this).prop('checked', $(this).val() === status);
                });
                $("#editFaqModal").removeClass("hidden");
            });

            // Tutup modal edit FAQ
            $("#closeModal, #cancelModal").on("click", function() {
                $("#editFaqModal").addClass("hidden");
            });

            // Submit form edit FAQ dengan Ajax dan spinner
            $('#editFaqForm').on('submit', function(e) {
                e.preventDefault();
                var faqId = $('#faq_id').val();
                var formData = $(this).serialize();
                showSpinner();
                $.ajax({
                    url: '/faq/' + faqId,
                    type: 'PATCH',
                    data: formData,
                    success: function(response) {
                        hideSpinner();
                        $("#editFaqModal").addClass("hidden");
                        toastr.success(response.message);
                        faqTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        hideSpinner();
                        toastr.error('Gagal memperbarui FAQ.');
                    }
                });
            });
        });
    </script>
@endsection
