@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-100 flex justify-center items-start pt-10 pb-10">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-700 py-6 px-8 text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Jawab Pertanyaan</h1>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                {{-- Peringatan jika sudah dijawab --}}
                @if ($alreadyAnswered)
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-xl">
                        <p class="font-semibold">Catatan:</p>
                        <p class="text-sm mt-1">Pertanyaan ini sudah pernah dijawab oleh admin sebelumnya.</p>
                        <p class="text-sm mt-2"><span class="font-semibold">Jawaban Sebelumnya:</span> {{ $faq->answer }}</p>
                        <p class="text-xs mt-1 text-gray-600">Status: {{ ucfirst($faq->status) }}</p>
                    </div>
                @endif

                {{-- Informasi Pertanyaan --}}
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold">Pertanyaan:</label>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-inner text-gray-800 text-sm">
                        {{ $question->question }}
                    </div>
                    <p class="text-xs text-gray-500">Dibuat pada: {{ $question->created_at->translatedFormat('d F Y H:i') }}
                    </p>
                </div>

                {{-- Form Jawaban --}}
                <form action="{{ route('faq.store', $question->id) }}" method="POST" class="space-y-6" id="answerForm"> 
                    @csrf

                    {{-- Dropdown Keputusan --}}
                    <div>
                        <label for="decision" class="block font-semibold text-gray-700 mb-2">Keputusan:</label>
                        <select name="decision" id="decision" required
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                            <option value="">-- Pilih Keputusan --</option>
                            <option value="approved">Terima</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>

                    {{-- Textarea Jawaban --}}
                    <div id="answerContainer" class="hidden">
                        <label for="answer" class="block font-semibold text-gray-700 mb-2">Jawaban:</label>
                        <textarea name="answer" id="answer" rows="5"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                            placeholder="Tuliskan jawaban di sini..."></textarea>
                    </div>

                    {{-- Checkbox Publish --}}
                    <div id="publishContainer" class="hidden">
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="checkbox" name="publish" class="form-checkbox text-green-600">
                            <span class="ml-2">Publish FAQ</span>
                        </label>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-4">
                        <button type="submit"
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition text-sm font-medium">
                            Simpan
                        </button>
                        <a href="{{ route('faq.index') }}"
                            class="w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow transition text-sm font-medium text-center">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const decisionSelect = document.getElementById('decision');
        const answerContainer = document.getElementById('answerContainer');
        const publishContainer = document.getElementById('publishContainer');

        decisionSelect.addEventListener('change', function() {
            const isApproved = this.value === 'approved';
            answerContainer.classList.toggle('hidden', !isApproved);
            publishContainer.classList.toggle('hidden', !isApproved);
        });

        $('#answerForm').on('submit', function() {
            showSpinner();
        });
    </script>
@endsection
