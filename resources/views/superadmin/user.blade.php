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

        .btn-add {
            background-color: #10b981;
            color: #ffffff;
        }

        .btn-add:hover {
            background-color: #059669;
        }

        /* Style khusus untuk tombol switch account */
        .btn-switch {
            background-color: #4F46E5;
            /* Indigo-600 */
            color: #ffffff;
        }

        .btn-switch:hover {
            background-color: #4338CA;
            /* Indigo-700 */
        }

        /* Transisi modal */
        .modal-transition {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Style wrapper input password untuk toggle icon */
        .input-group {
            position: relative;
        }

        .input-group .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 65%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
            font-size: 1.2rem;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h1 class="text-white text-2xl font-bold">Daftar Pengguna</h1>
                <button id="openNewUserModal"
                    class="btn-add px-4 py-2 rounded hover:bg-green-700 focus:outline-none focus:ring">
                    Tambah Pengguna
                </button>
            </div>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table id="users-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 uppercase font-semibold text-sm">
                                <th class="border px-4 py-2 text-center">No</th>
                                <th class="border px-4 py-2 text-center">Nama</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Whatsapp</th>
                                <th class="border px-4 py-2 text-left">Role</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengguna Baru -->
    <div id="newUserModal" class="fixed inset-0 hidden z-50 overflow-y-auto modal-transition" role="dialog"
        aria-modal="true" aria-labelledby="newUserModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full relative p-0">
                <form id="newUserForm">
                    @csrf
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 id="newUserModalTitle" class="text-lg font-bold text-gray-800">Tambah Pengguna Baru</h5>
                        <button type="button" id="closeNewUserModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none"
                            aria-label="Tutup">&times;</button>
                    </div>
                    <div class="px-4 py-5 space-y-4">
                        <div>
                            <label for="new_user_name" class="block text-gray-700 mb-1">Nama</label>
                            <input type="text" id="new_user_name" name="name"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div>
                            <label for="new_user_email" class="block text-gray-700 mb-1">Email</label>
                            <input type="email" id="new_user_email" name="email"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div>
                            <label for="new_user_whatsapp" class="block text-gray-700 mb-1">Whatsapp</label>
                            <input type="text" id="new_user_whatsapp" name="whatsapp"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                            <i class="fa-solid fa-eye toggle-password" data-target="#password"></i>
                        </div>
                        <div class="input-group">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                            <i class="fa-solid fa-eye toggle-password" data-target="#password_confirmation"></i>
                        </div>
                        <div>
                            <span class="block text-gray-700 mb-1">Role</span>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="superAdmin" class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">Super Admin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="admin" class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">Admin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="user" class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">User</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelNewUserModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit" id="submitNewUser"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna -->
    <div id="editUserModal" class="fixed inset-0 hidden z-50 overflow-y-auto modal-transition" role="dialog"
        aria-modal="true" aria-labelledby="editUserModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg w-full relative p-0">
                <form id="editUserForm">
                    @csrf
                    @method('PATCH')
                    <div class="px-4 py-3 bg-gray-100 flex justify-between items-center border-b">
                        <h5 id="editUserModalTitle" class="text-lg font-bold text-gray-800">Edit Pengguna</h5>
                        <button type="button" id="closeEditUserModal"
                            class="text-gray-700 hover:text-gray-900 text-2xl leading-none"
                            aria-label="Tutup">&times;</button>
                    </div>
                    <div class="px-4 py-5 space-y-4">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div>
                            <label for="edit_user_name" class="block text-gray-700 mb-1">Nama</label>
                            <input type="text" id="edit_user_name" name="name"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div>
                            <label for="edit_user_email" class="block text-gray-700 mb-1">Email</label>
                            <input type="email" id="edit_user_email" name="email"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div>
                            <label for="edit_user_whatsapp" class="block text-gray-700 mb-1">Whatsapp</label>
                            <input type="text" id="edit_user_whatsapp" name="whatsapp"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="edit_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="edit_password"
                                class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                            <i class="fa-solid fa-eye toggle-password" data-target="#edit_password"></i>
                        </div>
                        <div class="input-group">
                            <label for="edit_password_confirmation"
                                class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                class="w-full border rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
                            <i class="fa-solid fa-eye toggle-password" data-target="#edit_password_confirmation"></i>
                        </div>
                        <div>
                            <span class="block text-gray-700 mb-1">Role</span>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="superAdmin"
                                        class="form-radio text-blue-600" required>
                                    <span class="ml-2">Super Admin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="admin" class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">Admin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="role" value="user" class="form-radio text-blue-600"
                                        required>
                                    <span class="ml-2">User</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-100 flex justify-end space-x-3 border-t">
                        <button type="button" id="cancelEditUserModal"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                        <button type="submit" id="submitEditUser"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Pengguna -->
    <div id="deleteConfirmModal" class="fixed inset-0 hidden z-50 overflow-y-auto modal-transition" role="dialog"
        aria-modal="true" aria-labelledby="deleteConfirmTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-md w-full relative p-6">
                <h5 id="deleteConfirmTitle" class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Hapus</h5>
                <p class="mb-6">Apakah Anda yakin akan menghapus pengguna ini?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelDeleteBtn"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                    <button id="confirmDeleteBtn"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none focus:ring">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Switch Account -->
    <div id="switchAccountModal" class="fixed inset-0 hidden z-50 overflow-y-auto modal-transition" role="dialog"
        aria-modal="true" aria-labelledby="switchAccountModalTitle">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 opacity-50" aria-hidden="true"></div>
            <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-md w-full relative p-6">
                <h5 id="switchAccountModalTitle" class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Switch Account
                </h5>
                <p id="switchAccountInfo" class="mb-6">
                    Anda akan switch ke akun: <strong id="switchName"></strong><br>
                    Email: <span id="switchEmail"></span><br>
                    Role: <span id="switchRole"></span>
                </p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelSwitchBtn"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none focus:ring">Batal</button>
                    <button id="confirmSwitchBtn"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring">Switch
                        Account</button>
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
            var deleteUserId = null;
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.getUser') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'whatsapp',
                        name: 'whatsapp'
                    },
                    {
                        data: 'role',
                        name: 'role'
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

            // Fungsi untuk membuka dan menutup modal dengan pengaturan fokus
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

            // Fungsi spinner
            function showSpinner() {
                $("#loadingOverlay").fadeIn(200);
            }

            function hideSpinner() {
                $("#loadingOverlay").fadeOut(200);
            }

            // Toggle password field
            $(document).on('click', '.toggle-password', function() {
                var target = $(this).data('target');
                var input = $(target);
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    $(this).removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    $(this).removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            // Pindah focus: Enter di field Whatsapp -> pindah ke field Password (form new & edit)
            $("#new_user_whatsapp").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#password").focus();
                }
            });
            $("#edit_user_whatsapp").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#edit_password").focus();
                }
            });

            // Pindah focus: Enter di field Password -> pindah ke field Konfirmasi Password (form new & edit)
            $("#password").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#password_confirmation").focus();
                }
            });
            $("#edit_password").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#edit_password_confirmation").focus();
                }
            });

            // Modal Tambah Pengguna
            $('#openNewUserModal').on('click', function() {
                openModal("#newUserModal", "#new_user_name");
            });
            $("#closeNewUserModal, #cancelNewUserModal").on("click", function() {
                closeModal("#newUserModal", "#openNewUserModal");
                $('#newUserForm')[0].reset();
            });
            $('#newUserForm').on('submit', function(e) {
                e.preventDefault();
                var $submitBtn = $('#submitNewUser').prop('disabled', true);
                showSpinner();
                $.ajax({
                    url: '/user',
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        closeModal("#newUserModal", "#openNewUserModal");
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                        $('#newUserForm')[0].reset();
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
                                'Gagal menyimpan pengguna baru.');
                        }
                        // Modal tetap terbuka agar data tidak hilang
                    },
                    complete: function() {
                        hideSpinner();
                        $submitBtn.prop('disabled', false);
                    }
                });
            });

            // Modal Edit Pengguna
            $(document).on('click', '.btn-edit', function() {
                var userId = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var whatsapp = $(this).data('whatsapp');
                var role = $(this).data('role');

                $('#edit_user_id').val(userId);
                $('#edit_user_name').val(name);
                $('#edit_user_email').val(email);
                $('#edit_user_whatsapp').val(whatsapp);
                $('#editUserModal input[name="role"][value="' + role + '"]').prop('checked', true);
                openModal("#editUserModal", "#edit_user_name");
            });
            $("#closeEditUserModal, #cancelEditUserModal").on("click", function() {
                closeModal("#editUserModal", "#openNewUserModal");
                $('#editUserForm')[0].reset();
            });
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                var userId = $('#edit_user_id').val();
                var $submitBtn = $('#submitEditUser').prop('disabled', true);
                showSpinner();
                $.ajax({
                    url: '/user/' + userId,
                    type: 'PATCH',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        closeModal("#editUserModal", "#openNewUserModal");
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
                                'Gagal memperbarui data pengguna.');
                        }
                        // Modal tidak ditutup agar data tidak hilang
                    },
                    complete: function() {
                        hideSpinner();
                        $submitBtn.prop('disabled', false);
                    }
                });
            });

            // Hapus Pengguna menggunakan modal konfirmasi
            $(document).on('click', '.btn-delete', function() {
                deleteUserId = $(this).data('id');
                openModal("#deleteConfirmModal", "#confirmDeleteBtn");
            });
            $("#cancelDeleteBtn").on("click", function() {
                closeModal("#deleteConfirmModal", "#openNewUserModal");
                deleteUserId = null;
            });
            $("#confirmDeleteBtn").on("click", function() {
                if (deleteUserId) {
                    showSpinner();
                    $.ajax({
                        url: '/user/' + deleteUserId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message ||
                                'Gagal menghapus pengguna.');
                        },
                        complete: function() {
                            hideSpinner();
                            closeModal("#deleteConfirmModal", "#openNewUserModal");
                            deleteUserId = null;
                        }
                    });
                }
            });

            // Event handler untuk tombol switch account
            $(document).on('click', '.btn-switch', function() {
                // Ambil data user dari atribut data
                switchUserId = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var role = $(this).data('role');
                // Update informasi di modal konfirmasi switch account
                $('#switchName').text(name);
                $('#switchEmail').text(email);
                $('#switchRole').text(role);
                // Tampilkan modal konfirmasi switch account
                openModal("#switchAccountModal", "#cancelSwitchBtn");
            });

            // Tombol batal di modal switch account
            $('#cancelSwitchBtn').on('click', function() {
                closeModal("#switchAccountModal", "#openNewUserModal");
                switchUserId = null;
            });

            // Tombol konfirmasi switch account
            $('#confirmSwitchBtn').on('click', function() {
                if (switchUserId) {
                    showSpinner();
                    $.ajax({
                        url: '/switch/' + switchUserId,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = response.redirect || '/dashboard';
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message ||
                                'Gagal melakukan switch account.');
                        },
                        complete: function() {
                            hideSpinner();
                        }
                    });
                }
            });

        });
    </script>
@endsection
