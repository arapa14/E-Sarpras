@extends('layouts.user')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Dashboard Pengaduan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-50 rounded-lg">
                <h3 class="font-bold text-blue-600">Total Pengaduan</h3>
                <p class="text-2xl">{{ $totalComplaints ?? 0 }}</p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg">
                <h3 class="font-bold text-green-600">Pengaduan Selesai</h3>
                <p class="text-2xl">{{ $complaintsCompleted ?? 0 }}</p>
            </div>
        </div>
        <div class="mt-6">
            <p class="text-gray-600">Konten tambahan (tabel/grafik) dapat ditambahkan di sini.</p>
        </div>
    </div>
@endsection
