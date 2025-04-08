<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pembaruan Pengaduan</title>
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
            background-color: #1D4ED8;
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
            color: #1D4ED8;
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
            background-color: #1D4ED8;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 300ms;
        }

        .btn:hover {
            background-color: #1E40AF;
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
            <h1>Pembaruan Pengaduan</h1>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <p>Halo, {{ $user->name }}!</p>
            <p>Kami ingin menginformasikan bahwa pengaduan Anda telah diperbarui. Berikut detail lengkapnya:</p>

            <!-- Detail Pengaduan -->
            <div class="section">
                <h3>Detail Pengaduan</h3>
                <div class="details">
                    <p><strong>Tanggal Pengaduan:</strong>
                        {{ \Carbon\Carbon::parse($complaint->created_at)->format('d M Y, H:i') }}</p>
                    <p><strong>Deskripsi Pengaduan:</strong></p>
                    <p>{{ $complaint->description }}</p>
                    <p><strong>Lokasi:</strong> {{ $complaint->location }}</p>
                    <p><strong>Saran:</strong> {{ $complaint->suggestion }}</p>
                    <p><strong>Status Saat Ini:</strong> {{ ucfirst($complaint->status) }}</p>
                    <p><strong>Gambar Sebelum:</strong></p>
                    @php
                        $beforeImages = is_array($complaint->before_image)
                            ? $complaint->before_image
                            : json_decode($complaint->before_image, true);
                    @endphp
                    @if (isset($beforeImages) && count($beforeImages) > 0)
                        @foreach ($beforeImages as $image)
                            <img src="{{ config('app.url') . '/storage/' . $image }}" alt="Gambar Sebelum">
                        @endforeach
                    @else
                        <p>Tidak ada gambar sebelum yang diunggah.</p>
                    @endif
                </div>
            </div>

            <!-- Detail Balasan Admin -->
            <div class="section">
                <h3>Balasan Admin</h3>
                <div class="details">
                    <p><strong>Status Terbaru:</strong> {{ ucfirst($newStatus) }}</p>
                    <p><strong>Waktu Respon:</strong> {{ round($response_time) }} menit</p>
                    <p><strong>Feedback:</strong></p>
                    <p>{{ $feedback }}</p>
                    <p><strong>Gambar Sesudah:</strong></p>
                    @php
                        $afterImages = is_array($afterImages) ? $afterImages : json_decode($afterImages, true);
                    @endphp
                    @if (isset($afterImages) && count($afterImages) > 0)
                        @foreach ($afterImages as $afterImage)
                            <img src="{{ config('app.url') . '/storage/' . $afterImage }}" alt="Gambar Sesudah">
                        @endforeach
                    @else
                        <p>Tidak ada gambar sesudah yang diunggah.</p>
                    @endif
                </div>
            </div>

            <!-- Tombol untuk melihat detail pengaduan -->
            <div class="btn-container">
                <a href="{{ $complaintLink }}" class="btn">Lihat Detail Pengaduan</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.</p>
            <p>Salam, <br> Tim Dukungan</p>
        </div>
    </div>
</body>

</html>
