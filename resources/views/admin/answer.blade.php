@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4 sm:p-6">
        <div class="w-full mx-2 sm:mx-0 max-w-full sm:max-w-5xl bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="bg-blue-700 px-6 py-4 sm:px-8 sm:py-6">
                <h1 class="text-white text-xl sm:text-2xl md:text-3xl font-bold text-center">Jawab Pertanyaan</h1>
            </div>
            <div class="p-4 sm:p-8 space-y-6">
                {{-- Peringatan jika sudah dijawab --}}
                @if ($alreadyAnswered)
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 sm:p-6 rounded">
                        <p class="font-semibold text-sm sm:text-base">Catatan:</p>
                        <p class="mt-1 text-xs sm:text-sm">Pertanyaan ini sudah pernah dijawab oleh admin sebelumnya.</p>
                        <p class="mt-2 text-xs sm:text-sm"><span class="font-semibold">Jawaban Sebelumnya:</span>
                            {{ $faq->answer }}</p>
                        <p class="mt-1 text-xs text-gray-600">Status: {{ ucfirst($faq->status) }}</p>
                    </div>
                @endif

                {{-- Informasi Pertanyaan --}}
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold text-sm sm:text-base">Pertanyaan:</label>
                    <p class="p-4 bg-gray-100 rounded-lg text-gray-800 shadow-inner text-sm sm:text-base">
                        {{ $question->question }}
                    </p>
                    <p class="text-xs text-gray-500">Dibuat pada: {{ $question->created_at->translatedFormat('d F Y H:i') }}
                    </p>
                </div>

                {{-- Form Jawaban --}}
                <form action="{{ route('faq.store', $question->id) }}" method="POST" class="space-y-6">
                    @csrf
                    {{-- Dropdown approval --}}
                    <div>
                        <label for="decision"
                            class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Keputusan:</label>
                        <select name="decision" id="decision" required
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:ring focus:border-blue-400">
                            <option value="">-- Pilih Keputusan --</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    {{-- Textarea jawaban, tampil hanya jika approved --}}
                    <div id="answerContainer" class="hidden">
                        <label for="answer"
                            class="block text-gray-700 font-semibold mb-2 text-sm sm:text-base">Jawaban:</label>
                        <textarea name="answer" id="answer" rows="6"
                            class="w-full border border-gray-300 rounded-lg p-3 text-sm sm:text-base focus:outline-none focus:ring focus:border-blue-400"
                            placeholder="Tuliskan jawaban disini..."></textarea>
                    </div>

                    {{-- Checkbox publish --}}
                    <div id="publishContainer" class="hidden">
                        <label class="inline-flex items-center text-gray-700 text-sm sm:text-base">
                            <input type="checkbox" name="publish" class="form-checkbox text-green-600">
                            <span class="ml-2">Publish FAQ</span>
                        </label>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring text-sm sm:text-base">
                            Simpan
                        </button>
                        <a href="{{ route('faq.index') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition duration-200 focus:outline-none focus:ring text-center text-sm sm:text-base">
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
            if (this.value === 'approved') {
                answerContainer.classList.remove('hidden');
                publishContainer.classList.remove('hidden');
            } else {
                answerContainer.classList.add('hidden');
                publishContainer.classList.add('hidden');
            }
        });
    </script>
@endsection
