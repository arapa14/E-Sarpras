@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Jawab Pertanyaan</h1>

            {{-- Peringatan jika sudah dijawab --}}
            @if ($alreadyAnswered)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
                    <p><strong>Catatan:</strong> Pertanyaan ini sudah pernah dijawab oleh admin sebelumnya.</p>
                    <p class="mt-2"><strong>Jawaban Sebelumnya:</strong> {{ $faq->answer }}</p>
                    <p class="text-sm text-gray-600 mt-1">Status: {{ ucfirst($faq->status) }}</p>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Pertanyaan:</label>
                <p class="mt-2 p-4 bg-gray-100 rounded">{{ $question->question }}</p>
                <p class="text-sm text-gray-500 mt-1">Dibuat pada: {{ $question->created_at->translatedFormat('d F Y H:i') }}
                </p>
            </div>

            <form action="{{ route('faq.store', $question->id) }}" method="POST" class="form-container">
                @csrf

                {{-- Dropdown approval --}}
                <div class="mb-4">
                    <label for="decision" class="block text-gray-700 font-semibold mb-1">Keputusan:</label>
                    <select name="decision" id="decision" required class="w-full border rounded p-2">
                        <option value="">-- Pilih --</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                {{-- Textarea jawaban, tampil hanya jika approved --}}
                <div id="answerContainer" class="mb-4 hidden">
                    <label for="answer" class="block text-gray-700 font-semibold">Jawaban:</label>
                    <textarea name="answer" id="answer" rows="4" class="w-full border rounded p-2"></textarea>
                </div>

                {{-- Checkbox publish --}}
                <div id="publishContainer" class="mb-4 hidden">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="publish" class="form-checkbox">
                        <span class="ml-2">Publish FAQ</span>
                    </label>
                </div>

                <div class="flex flex-wrap gap-3 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                    <a href="{{ route('faq.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Kembali
                    </a>
                </div>
            </form>
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
