<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    // Menampilkan halaman index lokasi
    public function index()
    {
        return view('superadmin.location');
    }

    // Mengambil data lokasi untuk DataTables
    public function getLocation()
    {
        $locations = Location::orderBy('created_at', 'asc')->get();
        try {
            return DataTables::of($locations)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<button type="button" class="action-icon btn-edit p-2" data-id="' . $row->id . '" data-location="' . htmlspecialchars($row->location, ENT_QUOTES) . '" title="Edit Lokasi">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>';
                    $btnDelete = '<button type="button" class="action-icon btn-delete p-2" data-id="' . $row->id . '" title="Hapus Lokasi">
                                    <i class="fa-solid fa-trash"></i>
                                </button>';
                    return '<div class="flex justify-center space-x-2">' . $btnEdit . $btnDelete . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    // Simpan lokasi baru
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|unique:locations,location',
        ]);

        try {
            $location = new Location();
            $location->location = $request->location;
            $location->save();

            return response()->json(['message' => 'Lokasi berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menyimpan lokasi.'], 500);
        }
    }

    // Update lokasi
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'location' => 'required|string|unique:locations,location,' . $location->id,
        ]);

        try {
            $location->location = $request->location;
            $location->save();

            return response()->json(['message' => 'Lokasi berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal memperbarui lokasi.'], 500);
        }
    }

    // Hapus lokasi
    public function destroy(Location $location)
    {
        try {
            $location->delete();
            return response()->json(['message' => 'Lokasi berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menghapus lokasi.'], 500);
        }
    }
}
