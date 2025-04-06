<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'question' => 'required|string',
        ]);

        try {
            $question = new Question();
            $question->question = $request->input('question');
            $question->save();

            return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pertanyaan.');
        }
    }

    public function getQuestion()
    {
        $questions = Question::orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'asc') // waktu terlama di atas
            ->get();

        return DataTables::of($questions)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                // Format tanggal dengan Carbon, misal: 15 Mar 2025 14:30
                return Carbon::parse($row->created_at)->format('d M Y H:i');
            })
            ->editColumn('status', function ($row) {
                // Definisikan opsi label dan class Tailwind untuk setiap status
                $options = [
                    'pending'  => ['label' => 'Pending',  'class' => 'bg-yellow-100 text-yellow-700 border border-yellow-500'],
                    'approved' => ['label' => 'Approved', 'class' => 'bg-blue-100 text-blue-700 border border-blue-500'],
                    'rejected' => ['label' => 'Rejected', 'class' => 'bg-red-100 text-red-700 border border-red-500'],
                ];

                $status = $row->status;
                $label = isset($options[$status]) ? $options[$status]['label'] : ucfirst($status);
                $class = isset($options[$status]) ? $options[$status]['class'] : '';

                // Tampilkan label status dalam elemen <span> tanpa dropdown
                return "<span class='px-2 py-1 rounded {$class}'>{$label}</span>";
            })
            ->addColumn('action', function ($row) {
                $buttonDetail = '<a href="' . route('faq.answer', $row->id) . '" class="action-icon btn-detail p-2" title="Lihat Detail">
                                <i class="fa-solid fa-eye fa-lg"></i>
                             </a>';
                return '<div class="flex justify-center space-x-2">' . $buttonDetail . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }



    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
