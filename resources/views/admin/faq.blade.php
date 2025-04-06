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
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-4 space-y-8">
        <!-- Tabel Pertanyaan -->
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-white text-2xl font-bold">Daftar Pertanyaan</h1>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table id="questions-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-sm">
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
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-green-600 px-6 py-4">
                <h1 class="text-white text-2xl font-bold">Daftar FAQ</h1>
            </div>
            <div class="p-4">
                <div class="flex justify-start mb-4">
                    <button id="openNewFaqModal" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Tambah FAQ
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="faq-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
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
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- Modal content -->
            <div
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full relative">
                <form id="newFaqForm">
                    @csrf
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center">
                        <h5 class="text-lg font-bold">Tambah FAQ Baru</h5>
                        <button type="button" id="closeNewFaqModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
                    </div>
                    <div class="px-4 py-5">
                        <div class="mb-4">
                            <label for="new_faq_question" class="block text-gray-700">Pertanyaan</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" id="new_faq_question" name="question"
                                rows="2" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="new_faq_answer" class="block text-gray-700">Jawaban</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" id="new_faq_answer" name="answer"
                                rows="3" required></textarea>
                        </div>
                        <div>
                            <label for="new_faq_status" class="block text-gray-700">Status</label>
                            <select class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                                id="new_faq_status" name="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end">
                        <button type="button" id="cancelNewFaqModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan
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
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- Modal content -->
            <div
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full relative">
                <form id="editFaqForm">
                    @csrf
                    @method('PATCH')
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center">
                        <h5 class="text-lg font-bold">Edit FAQ</h5>
                        <button type="button" id="closeModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
                    </div>
                    <div class="px-4 py-5">
                        <input type="hidden" id="faq_id" name="faq_id">
                        <div class="mb-4">
                            <label for="faq_question" class="block text-gray-700">Pertanyaan</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" id="faq_question" name="question"
                                rows="2" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="faq_answer" class="block text-gray-700">Jawaban</label>
                            <textarea class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" id="faq_answer" name="answer"
                                rows="3" required></textarea>
                        </div>
                        <div>
                            <label for="faq_status" class="block text-gray-700">Status</label>
                            <select class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" id="faq_status"
                                name="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end">
                        <button type="button" id="cancelModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan
                            Perubahan</button>
                    </div>
                </form>
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

            // Buka modal tambah FAQ
            $(document).on('click', '#openNewFaqModal', function() {
                $("#newFaqModal").removeClass("hidden");
            });

            // Tutup modal tambah FAQ
            $("#closeNewFaqModal, #cancelNewFaqModal").on("click", function() {
                $("#newFaqModal").addClass("hidden");
            });

            // Submit form tambah FAQ via Ajax
            $('#newFaqForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/faq', // Pastikan route POST untuk menyimpan FAQ baru sudah disediakan
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#newFaqModal").addClass("hidden");
                        toastr.success(response.message);
                        // Reload DataTable FAQ untuk menampilkan data terbaru
                        $('#faq-table').DataTable().ajax.reload(null, false);
                        // Reset form input
                        $('#newFaqForm')[0].reset();
                    },
                    error: function(xhr) {
                        toastr.error('Gagal menyimpan FAQ baru.');
                    }
                });
            });

            // Handler untuk change status (dropdown di tabel FAQ)
            $(document).on('change', '.faq-status-dropdown', function() {
                var faqId = $(this).data('id');
                var status = $(this).val();
                var dropdown = $(this);

                $.ajax({
                    url: '/faq/' + faqId + '/status', // pastikan route ini sesuai
                    type: 'PATCH',
                    data: {
                        status: status
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var selectedOption = dropdown.find('option:selected').data('class');
                        dropdown.removeClass().addClass(
                            'faq-status-dropdown border border-gray-300 rounded p-1 ' +
                            selectedOption);
                        toastr.success(response.message);
                        faqTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        toastr.error('Gagal memperbarui status.');
                    }
                });
            });

            // Handler untuk tombol delete FAQ
            $(document).on('click', '.btn-delete', function() {
                var faqId = $(this).data('id');
                if (confirm('Apakah Anda yakin akan menghapus FAQ ini?')) {
                    $.ajax({
                        url: '/faq/' + faqId, // pastikan route DELETE ini sesuai
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            faqTable.ajax.reload(null, false);
                        },
                        error: function(xhr) {
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
                $('#faq_status').val(status);
                $("#editFaqModal").removeClass("hidden");
            });

            // Tutup modal edit FAQ
            $("#closeModal, #cancelModal").on("click", function() {
                $("#editFaqModal").addClass("hidden");
            });

            // Submit form edit FAQ dengan Ajax
            $('#editFaqForm').on('submit', function(e) {
                e.preventDefault();
                var faqId = $('#faq_id').val();
                var formData = $(this).serialize();

                $.ajax({
                    url: '/faq/' + faqId, // pastikan route PATCH update FAQ ini sesuai
                    type: 'PATCH',
                    data: formData,
                    success: function(response) {
                        $("#editFaqModal").addClass("hidden");
                        toastr.success(response.message);
                        faqTable.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        toastr.error('Gagal memperbarui FAQ.');
                    }
                });
            });
        });
    </script>
@endsection
