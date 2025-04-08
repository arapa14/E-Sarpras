<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pengaduan</title>
    <style>
        /* Reset sederhana */
        body,
        p,
        h1,
        h3 {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #10B981;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .content {
            padding: 20px 30px 30px;
        }

        .content p {
            margin-bottom: 15px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h3 {
            margin-bottom: 10px;
            color: #10B981;
        }

        .details {
            background: #f0f4f8;
            padding: 15px;
            border-radius: 5px;
        }

        .details p {
            margin: 8px 0;
        }

        .details img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 5px;
        }

        .btn-container {
            text-align: center;
            margin: 25px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #10B981;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 300ms;
        }

        .btn:hover {
            background-color: #059669;
        }

        .footer {
            background: #f0f4f8;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Pengaduan Berhasil Dikirim</h1>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <p>Halo, {{ $user->name }}!</p>
            <p>Terima kasih telah mengirim pengaduan kepada kami. Berikut adalah detail pengaduan yang Anda kirimkan:
            </p>

            <!-- Detail Pengaduan -->
            <div class="section">
                <h3>Detail Pengaduan</h3>
                <div class="details">
                    <p><strong>Tanggal Pengaduan:</strong>
                        {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y, H:i') }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <p>{{ $complaint->description }}</p>
                    <p><strong>Lokasi:</strong> {{ $complaint->location }}</p>
                    <p><strong>Saran:</strong></p>
                    <p>{{ $complaint->suggestion }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($complaint->status) }}</p>
                    <p><strong>Gambar Pengaduan:</strong></p>
                    @php
                        $beforeImages = is_array($beforeImages)
                            ? $beforeImages
                            : json_decode($complaint->before_image, true);
                    @endphp
                    @if (isset($beforeImages) && count($beforeImages) > 0)
                        @foreach ($beforeImages as $image)
                            <img src="{{ config('app.url') . '/storage/' . $image }}" alt="Gambar Pengaduan">
                        @endforeach
                    @else
                        <p>Tidak ada gambar yang diunggah.</p>
                    @endif
                </div>
            </div>

            <!-- Tombol untuk melihat detail pengaduan -->
            <div class="btn-container">
                <a href="{{ route('complaint.list.detail', $complaint->id) }}" class="btn">Lihat Detail Pengaduan</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.</p>
            <p>Salam,<br> Tim Dukungan</p>
        </div>
    </div>
</body>

</html>
