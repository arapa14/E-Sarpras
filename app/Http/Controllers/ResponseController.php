<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
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
    public function store(Request $request, Complaint $complaint)
    {
        // Validasi input
        $request->validate([
            'feedback'    => 'required|string',
            'after_image' => 'nullable|image|max:2048',
            'status'      => 'required|in:pending,progress,selesai',
        ]);

        // Hitung durasi respon dalam menit
        $duration = \Carbon\Carbon::parse($complaint->created_at)->diffInMinutes(now());

        // Persiapkan data untuk disimpan ke table responses
        $data = [
            'complaint_id'  => $complaint->id,
            'feedback'      => $request->feedback,
            'response_time' => $duration, // Simpan jumlah menit
        ];

        // Proses upload gambar jika ada
        if ($request->hasFile('after_image')) {
            $path = $request->file('after_image')->store('responses', 'public');
            $data['after_image'] = $path;
        }

        // Simpan data respon ke table responses
        Response::create($data);

        // Perbarui status pengaduan
        $complaint->update(['status' => $request->status]);

        return redirect()->route('complaint.list.detail', $complaint->id)
            ->with('success', 'Respon berhasil dikirim.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Response $response)
    {
        //
    }
}
