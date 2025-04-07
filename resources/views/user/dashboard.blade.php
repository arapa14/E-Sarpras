@extends('layouts.user')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Pengaduan</h2>
                <a href="{{ route('complaint.index') }}"
                    class="mt-4 sm:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    Buat Pengaduan
                </a>
            </div>

            <!-- Informasi Akun Pengguna -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pengguna</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-700">
                            <span class="font-semibold">Nama:</span> {{ $user->name }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold">Email:</span> {{ $user->email }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-700">
                            <span class="font-semibold">No. WhatsApp:</span> {{ $user->whatsapp }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-semibold">Tanggal Akun Dibuat:</span> {{ $user->created_at->format('d-m-Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistik Pengaduan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 bg-blue-50 rounded-lg shadow">
                    <h3 class="font-bold text-blue-600 text-lg">Total Pengaduan</h3>
                    <p class="text-3xl font-semibold mt-2">{{ $totalComplaints }}</p>
                </div>
                <div class="p-5 bg-yellow-50 rounded-lg shadow">
                    <h3 class="font-bold text-yellow-600 text-lg">Pengaduan Pending</h3>
                    <p class="text-3xl font-semibold mt-2">{{ $complaintsPending }}</p>
                </div>
                <div class="p-5 bg-orange-50 rounded-lg shadow">
                    <h3 class="font-bold text-orange-600 text-lg">Pengaduan On Progress</h3>
                    <p class="text-3xl font-semibold mt-2">{{ $complaintsProgress }}</p>
                </div>
                <div class="p-5 bg-green-50 rounded-lg shadow">
                    <h3 class="font-bold text-green-600 text-lg">Pengaduan Selesai</h3>
                    <p class="text-3xl font-semibold mt-2">{{ $complaintsCompleted }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
