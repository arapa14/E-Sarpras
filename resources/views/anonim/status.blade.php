@extends('layouts.guest')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-lg mx-auto bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded-xl mb-6">
            🚧 Sistem ini masih dalam tahap pengembangan. Beberapa fitur mungkin belum tersedia sepenuhnya.
        </div>

        <div class="max-w-lg mx-auto bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-semibold mb-4">Status Laporan</h3>

            @if ($anonim)
                <p><strong>Kode Tiket:</strong> {{ $anonim->ticket }}</p>
                <p><strong>Deskripsi:</strong> {{ $anonim->description }}</p>
                <p><strong>Lokasi:</strong> {{ $anonim->location }}</p>
                <p><strong>Status:</strong> <span class="capitalize">{{ $anonim->status }}</span></p>
                @if ($anonim->before_image)
                    <img src="{{ asset('storage/' . $anonim->before_image) }}" alt="Before Image" class="mt-4">
                @endif
            @else
                <p class="text-red-600">Data dengan kode tiket tersebut tidak ditemukan.</p>
            @endif
        </div>
    </div>
@endsection
