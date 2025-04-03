<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Store a newly created resource in storage.P_
     */
    public function store(Request $request, Complaint $complaint)
    {
        // Validasi input, pastikan after_image adalah array dan minimal memiliki 1 gambar
        $request->validate([
            'feedback'      => 'required|string',
            'after_image'   => 'required|array|min:1',
            'after_image.*' => 'required|file|image|mimes:jpg,png,jpeg|max:2048',
            'status'        => 'required|in:pending,progress,selesai',
        ]);

        // Hitung durasi respon dalam menit
        $duration = \Carbon\Carbon::parse($complaint->created_at)->diffInMinutes(now());

        // Persiapkan data untuk disimpan ke table responses
        $data = [
            'complaint_id'  => $complaint->id,
            'feedback'      => $request->feedback,
            'new_status'    => $request->status,
            'response_time' => $duration, // Simpan jumlah menit
        ];

        // Inisialisasi array untuk menyimpan path gambar
        $imagePaths = [];

        // Proses upload gambar, karena gambar tidak opsional maka selalu ada
        $directory = 'responses';
        if (!Storage::exists("public/{$directory}")) {
            Storage::makeDirectory("public/{$directory}");
        }
        foreach ($request->file('after_image') as $imageFile) {
            $path = $imageFile->store($directory, 'public');
            $imagePaths[] = $path;
        }
        $data['after_image'] = json_encode($imagePaths);

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
