<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name }}</title>
    <link rel="icon" type="image/png" href="{{ asset($logo) }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset($logo) }}" alt="Logo e-Sarpras" class="w-10 h-10 mr-2">
                <h1 class="text-xl font-bold">{{ $name }}</h1>
            </div>
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Login</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 space-y-12">
        <!-- Web Info Section -->
        <section id="web-info" class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2">
                <img src="{{ asset('storage/logos/e-sarpras-landing.png') }}" alt="Informasi e-Sarpras"
                    class="w-full rounded-lg shadow">
            </div>
            <div class="md:w-1/2 md:pl-8 mt-4 md:mt-0">
                <h2 class="text-2xl font-bold mb-4">Apa itu e-Sarpras?</h2>
                <p class="text-gray-700">
                    e-Sarpras adalah aplikasi yang memudahkan pengelolaan sarana dan prasarana. Dengan e-Sarpras, Anda
                    dapat melaporkan kerusakan, memantau status perbaikan, dan mengakses informasi terkini seputar
                    fasilitas yang ada. Aplikasi ini dirancang untuk meningkatkan efisiensi dan transparansi pengelolaan
                    aset.
                </p>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq">
            <h2 class="text-2xl font-bold mb-4">FAQ</h2>
            <div class="space-y-4">
                @forelse ($faqs as $faq)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold">{{ $faq->question }}</h3>
                        <p class="mt-2 text-gray-700">{{ $faq->answer }}</p>
                    </div>
                @empty
                    <p class="text-gray-700">Tidak ada pertanyaan yang tersedia.</p>
                @endforelse
            </div>
        </section>

        <!-- Tutorial Membuat Laporan Section -->
        <section id="tutorial">
            <h2 class="text-2xl font-bold mb-4">Tutorial Membuat Laporan</h2>
            <div class="bg-white p-4 rounded-lg shadow">
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Login ke akun e-Sarpras Anda.</li>
                    <li>Pilih menu "Buat Laporan".</li>
                    <li>Isi form laporan dengan informasi yang diperlukan.</li>
                    <li>Submit laporan dan tunggu konfirmasi dari admin.</li>
                </ol>
            </div>
        </section>

        <!-- Form Kirim Pertanyaan Section -->
        <section id="pertanyaan">
            <h2 class="text-2xl font-bold mb-4">Kirim Pertanyaan</h2>
            <div class="bg-white p-6 rounded-lg shadow">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('question.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="question" class="block text-gray-700 font-medium mb-2">Pertanyaan Anda</label>
                        <textarea name="question" id="question" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tulis pertanyaan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kirim
                        Pertanyaan</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center p-4">
        &copy; {{ date('Y') }} SMKN 1 Jakarta. All rights reserved.
    </footer>
</body>

</html>
