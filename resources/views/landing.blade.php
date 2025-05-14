@extends('layouts.guest')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">


  <!-- Scroll Indicator -->
  <div id="progressBarContainer" style="position: fixed; top: 0; left: 0; width: 100%; height: 4px; background-color: #e5e7eb; z-index: 9999;">
  <div id="progressBarHorizontal" style="
    height: 100%;
    width: 0;
    background-image: linear-gradient(to right, #3b82f6, #6366f1, #7c3aed);
    transition: width 0.2s ease-out;
  "></div>
</div>
<!-- HERO SEKYEN -->
<section id="hero" class="relative h-screen flex items-center bg-gradient-to-b from-blue-300 via-blue-200 to-blue-100 overflow-hidden">
  <!-- Overlay gradient -->
  <div class="absolute inset-0 bg-gradient-to-b from-blue-300 via-blue-200 to-blue-100 opacity-30 z-10"></div>

  <!-- Container -->
  <div class="relative z-20 flex flex-col-reverse lg:flex-row items-center justify-between w-full max-w-[1280px] px-6 md:px-10 mx-auto">
    <!-- TEXT AREA -->
    <div class="w-full lg:w-1/2 text-left mb-10 lg:mb-0" data-aos="fade-right" data-aos-duration="1000">
    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-extrabold leading-tight text-blue-900 drop-shadow-md">
  Pengaduan Sarana Prasarana
</h2>
<p class="text-base sm:text-lg md:text-xl text-blue-700 mt-4 mb-8 max-w-xl drop-shadow-sm">
  E-Sarpras memudahkan Anda melaporkan kerusakan, memantau perbaikan, dan mendapatkan informasi real-time dengan mudah.
</p>
      <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">
          Mulai Sekarang
        </a>
        <a href="#features" class="px-6 py-3 border border-white text-white font-semibold rounded-full hover:bg-white hover:text-blue-600 transition">
          Pelajari Lebih Lanjut
        </a>
      </div>
    </div>

    <!-- SLIDER / IMAGE -->
    <div class="w-full lg:w-1/2 mb-6 lg:mb-0 scale-[1.08] md:scale-[1.1] xl:scale-100" data-aos="fade-left" data-aos-duration="1000">
    <div class="swiper mySwiper rounded-xl overflow-hidden shadow-lg">
        <div class="swiper-wrapper">
            @foreach (['storage/logos/3.png', 'storage/logos/2.jpg', 'storage/logos/1.jpg', 'storage/logos/slide4.jpg', 'storage/logos/slide5.jpg'] as $slide)
                <div class="swiper-slide">
                    <img src="{{ asset($slide) }}" alt="Slide Image" class="w-full h-auto object-cover">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
    </div>
</section>


<!-- Features Section -->
<section id="features" class="py-16 bg-gradient-to-br from-blue-50 via-white to-blue-100" data-aos="fade-up" data-aos-duration="1000">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Keunggulan e-Sarpras</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

     <!-- Feature 1: Mudah Digunakan -->
     <div class="flex flex-col items-center text-center p-8 rounded-2xl shadow-md bg-white border border-gray-100 transition-transform duration-500 hover:scale-105 hover:-translate-y-2"
           data-aos="zoom-in" data-aos-delay="100">
        <lottie-player src="https://lottie.host/09494c5b-ba05-4d98-9147-0284e6627b49/5laDpKXA0Y.json" background="transparent" speed="1"
                       style="width: 80px; height: 80px;" loop autoplay></lottie-player>
        <h3 class="text-2xl font-semibold mb-2">Mudah Digunakan</h3>
        <p class="text-gray-600">Antarmuka yang intuitif memudahkan setiap pengguna untuk mengakses informasi dengan cepat.</p>
      </div>

      <!-- Feature 2: Real Time -->
      <div class="flex flex-col items-center text-center p-8 rounded-2xl shadow-md bg-white border border-gray-100 transition-transform duration-500 hover:scale-105 hover:-translate-y-2"
           data-aos="zoom-in" data-aos-delay="200">
        <lottie-player src="https://lottie.host/7a6afc3f-160f-4aae-ba1e-8fc592b75e5f/GuSs75tKrt.json" background="transparent" speed="1"
                       style="width: 80px; height: 80px;" loop autoplay></lottie-player>
        <h3 class="text-2xl font-semibold mb-2">Real Time</h3>
        <p class="text-gray-600">Pantau status dan laporan secara langsung dengan informasi Real-Time</p>
      </div>

      <!-- Feature 3: Transparan -->
      <div class="flex flex-col items-center text-center p-8 rounded-2xl shadow-md bg-white border border-gray-100 transition-transform duration-500 hover:scale-105 hover:-translate-y-2"
           data-aos="zoom-in" data-aos-delay="300">
        <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_9cyyl8i4.json" background="transparent" speed="1"
                       style="width: 80px; height: 80px;" loop autoplay></lottie-player>
        <h3 class="text-2xl font-semibold mb-2">Transparan</h3>
        <p class="text-gray-600">Meningkatkan akuntabilitas dengan pelaporan dan pemantauan yang transparan.</p>
      </div>
        </div>
    </div>
</section>


<!-- FAQ Section -->
<section id="faq" class="py-16 bg-gradient-to-br from-blue-50 via-white to-blue-100" data-aos="fade-up" data-aos-duration="1000">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Frequently Asked Questions (FAQ)</h2>
        <div class="space-y-6">
            @forelse ($faqs->where('status', 'published') as $index => $faq)
                <div x-data="{ open: false }"
                    class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100"
                    data-aos="slide-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <button @click="open = !open"
                        class="w-full px-8 py-6 text-left flex items-center justify-between focus:outline-none hover:bg-gray-50 transition">
                        <span class="text-xl md:text-2xl font-semibold text-blue-600">{{ $faq->question }}</span>
                        <svg x-show="!open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse
                        class="px-8 pb-6 text-base md:text-lg text-gray-600 border-t border-gray-200">
                        {{ $faq->answer }}
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center bg-white rounded-2xl shadow p-10 text-center"
                     data-aos="fade-in" data-aos-delay="200">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7 12a5 5 0 0110 0 5 5 0 01-10 0z"></path>
                    </svg>
                    <p class="text-gray-500 text-xl">Belum ada pertanyaan yang diajukan.</p>
                    <p class="text-gray-400 mt-2">Silakan kirim pertanyaan Anda melalui form di bawah.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Tutorial Section -->
<section id="tutorial" class="py-16 bg-gradient-to-br from-blue-50 via-white to-blue-100">
<div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Cara Membuat Laporan</h2>
        <div class="space-y-10">
            <!-- Langkah 1 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="100">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        1
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Buat Akun</h3>
                    <p class="text-gray-600">Daftarkan diri Anda dan lengkapi data akun dengan benar.</p>
                </div>
            </div>
            <!-- Langkah 2 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="200">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        2
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Login</h3>
                    <p class="text-gray-600">Masuk ke akun E-Sarpras Anda menggunakan email dan password.</p>
                </div>
            </div>
            <!-- Langkah 3 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="300">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        3
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pilih Menu Pengaduan</h3>
                    <p class="text-gray-600">Klik menu <span class="font-medium">"Buat Pengaduan" </span>di dashboard Anda.</p>
                </div>
            </div>
            <!-- Langkah 4 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="400">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        4
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Isi Form Laporan</h3>
                    <p class="text-gray-600">Lengkapi informasi pengaduan dengan jelas dan lengkap agar mudah diproses.</p>
                </div>
            </div>
            <!-- Langkah 5 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="500">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        5
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    Kirim Laporan</h3>
                    <p class="text-gray-600">Tekan tombol<span class="font-medium">"Submit"</span>dan tunggu konfirmasi dari admin.</p>
                </div>
            </div>
            <!-- Langkah 6 -->
            <div class="flex items-start space-x-4" data-aos="fade-right" data-aos-delay="600">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold shadow-md">
                        6
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-all w-full border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Cek Riwayat</h3>
                    <p class="text-gray-600">Pantau status laporan Anda di menu <span class="font-medium">"Riwayat Pengaduan"</span>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Pertanyaan Section -->
<section id="pertanyaan" class="py-16 bg-gradient-to-br from-blue-50 via-white to-blue-100" data-aos="fade-up" data-aos-duration="1000">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Kirim Pertanyaan</h2>
        <div class="bg-white p-10 rounded-2xl shadow-xl hover:shadow-2xl transition-all max-w-2xl mx-auto border border-gray-100"
             data-aos="zoom-in" data-aos-delay="100">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-800 p-4 rounded mb-6">{{ session('error') }}</div>
            @endif
            <form action="{{ route('question.store') }}" method="POST"
                onsubmit="return validateAndSubmitQuestionForm()">
                @csrf
                <div class="mb-6">
                    <label for="question" class="block text-xl font-medium mb-2 text-gray-700">Pertanyaan Anda</label>
                    <textarea name="question" id="question" rows="4"
                        class="w-full px-5 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Jika anda memiliki pertanyaan atau menemukan bug, silahkan tuliskan di sini"></textarea>
                </div>
                <button type="submit"
                    class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-full shadow-lg hover:from-blue-700 hover:to-blue-800 transition duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kirim Pertanyaan
                </button>
            </form>
        </div>
    </div>
</section>

  <!-- Scroll-to-Top Button -->
  <button id="scrollTopBtn" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">↑</button>
  @stack('scripts')

  <script>
     const progressBar = document.getElementById('progressBarHorizontal');

function updateProgressBar() {
  const scrollTop = window.scrollY;
  const windowHeight = window.innerHeight;
  const fullHeight = document.body.scrollHeight - windowHeight;
  const percentage = Math.min((scrollTop / fullHeight) * 100, 100);

  progressBar.style.width = `${percentage}%`;
}

window.addEventListener('scroll', updateProgressBar);
window.addEventListener('load', updateProgressBar);

  </script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<script>
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 900,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>


@endsection