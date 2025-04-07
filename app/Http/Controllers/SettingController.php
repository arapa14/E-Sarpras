<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    // Menampilkan halaman index setting
    public function index()
    {
        // Mengambil data dalam bentuk array [key => value]
        $settings = Setting::pluck('value', 'key')->toArray();

        // Lalu passing ke view
        return view('superadmin.setting', compact('settings'));
    }

    // Update setting
    public function update(Request $request)
    {
        // Validasi input yang dikirimkan dari form
        $request->validate([
            'name' => 'nullable|string',
            'logo' => 'nullable|image',
            'main_image' => 'nullable|image',
        ]);


        try {
            $isUpdated = false;

            if ($request->filled('name')) {
                $name = $request->input('name');
                Setting::where('key', 'name')
                    ->update(['value' => $name]);
                $isUpdated = true;
            }

            // Update logo sistem
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('logos', 'public');

                // Update path di tabel settings
                Setting::where('key', 'logo')
                    ->update(['value' => 'storage/' . $path]);

                $isUpdated = true;
            }

            // Update main image
            if ($request->hasFile('main_image')) {
                $path = $request->file('main_image')->store('logos', 'public');

                // Update path di tabel settings
                Setting::where('key', 'main_image')
                    ->update(['value' => 'storage/' . $path]);

                $isUpdated = true;
            }

            return response()->json([
                'updated' => $isUpdated,
                'message' => $isUpdated ? 'Setting berhasil diperbarui.' : 'Tidak ada perubahan.',
                'redirect' => route('setting.index')
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal memperbarui setting.'], 500);
        }
    }
}
