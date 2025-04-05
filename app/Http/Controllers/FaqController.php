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
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.faq');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // DataTables untuk FAQ
    public function getFaq()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();

        return DataTables::of($faqs)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d M Y H:i');
            })
            ->editColumn('status', function ($row) {
                $options = [
                    'draft' => ['label' => 'Draft', 'class' => 'bg-gray-100 text-gray-700 p-1 rounded'],
                    'published' => ['label' => 'Published', 'class' => 'bg-green-100 text-green-700 p-1 rounded'],
                ];
                $currentClass = $options[$row->status]['class'] ?? '';
                return "<span class='{$currentClass}'>{$options[$row->status]['label']}</span>";
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    // Tampilkan halaman untuk menjawab pertanyaan
    public function answer(Question $question)
    {
        $faq = \App\Models\Faq::where('question', $question->question)->first();
        $alreadyAnswered = $faq !== null;

        return view('admin.answer', compact('question', 'alreadyAnswered', 'faq'));
    }


    /**
     * Store a newly created resource in storage.
     */
    // Simpan jawaban admin, ubah status question dan simpan data ke tabel FAQ
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'answer'   => 'required_if:decision,approved|string',
        ]);

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
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        //
    }
}
