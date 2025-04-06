<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Menampilkan halaman FAQ.
     */
    public function index()
    {
        return view('admin.faq');
    }

    /**
     * DataTables untuk FAQ.
     */
    public function getFaq()
    {
        $faqs = Faq::orderByRaw("FIELD(status, 'published', 'draft')")
            ->orderBy('created_at', 'asc')
            ->get();

        return DataTables::of($faqs)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d M Y H:i');
            })
            ->editColumn('status', function ($row) {
                $options = [
                    'draft'     => ['label' => 'Draft',     'class' => 'bg-gray-100 text-gray-700 p-1 rounded'],
                    'published' => ['label' => 'Published', 'class' => 'bg-green-100 text-green-700 p-1 rounded'],
                ];
                $currentClass = $options[$row->status]['class'] ?? '';
                $html = "<select class='faq-status-dropdown border border-gray-300 rounded p-1 {$currentClass}' data-id='{$row->id}'>";
                foreach ($options as $key => $option) {
                    $selected = ($row->status === $key) ? 'selected' : '';
                    $html .= "<option value='{$key}' data-class='{$option['class']}' {$selected}>{$option['label']}</option>";
                }
                $html .= "</select>";
                return $html;
            })
            ->addColumn('action', function ($row) {
                // Tombol untuk edit (buka modal inline) dan delete
                $btnEdit = '<button type="button" class="action-icon btn-edit p-2" data-id="' . $row->id . '" data-question="' . htmlspecialchars($row->question, ENT_QUOTES) . '" data-answer="' . htmlspecialchars($row->answer, ENT_QUOTES) . '" data-status="' . $row->status . '" title="Edit FAQ">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>';
                $btnDelete = '<button type="button" class="action-icon btn-delete p-2" data-id="' . $row->id . '" title="Delete FAQ">
                            <i class="fa-solid fa-trash"></i>
                        </button>';
                return '<div class="flex justify-center space-x-2">' . $btnEdit . $btnDelete . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Menampilkan halaman untuk menjawab pertanyaan.
     */
    public function answer(Question $question)
    {
        $faq = Faq::where('question', $question->question)->first();
        $alreadyAnswered = $faq !== null;
        return view('admin.answer', compact('question', 'alreadyAnswered', 'faq'));
    }

    /**
     * Simpan jawaban admin, ubah status question, dan simpan data ke tabel FAQ.
     */
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'answer'   => 'required_if:decision,approved|nullable|string',
        ]);
        // dd ($request->decision);

        try {
            if ($request->decision === 'approved') {
                $question->status = 'approved';
                $question->save();

                $faq = new Faq();
                $faq->question = $question->question;
                $faq->answer = $request->input('answer');
                $faq->status = $request->has('publish') ? 'published' : 'draft';
                $faq->save();
            } else {
                $question->status = 'rejected';
                $question->save();
            }

            return redirect()->route('faq.index')->with('success', 'Pertanyaan berhasil diproses.');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan jawaban.');
        }
    }

    /**
     * Menyimpan FAQ baru melalui input form.
     */
    public function storeNew(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'status'   => 'required|in:draft,published',
        ]);

        try {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->status   = $request->status;
            $faq->save();

            return response()->json(['message' => 'FAQ berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menyimpan FAQ.'], 500);
        }
    }

    /**
     * Update data FAQ (proses inline edit via modal).
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'status'   => 'required|in:draft,published',
        ]);

        try {
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->status   = $request->status;
            $faq->save();

            return response()->json(['message' => 'FAQ berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal memperbarui FAQ.'], 500);
        }
    }

    /**
     * Update status FAQ (melalui dropdown di DataTables).
     */
    public function updateStatus(Request $request, Faq $faq)
    {
        $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        try {
            $faq->status = $request->status;
            $faq->save();

            return response()->json(['message' => 'Status FAQ berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal memperbarui status FAQ.'], 500);
        }
    }

    /**
     * Hapus FAQ.
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            return response()->json(['message' => 'FAQ berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menghapus FAQ.'], 500);
        }
    }
}
