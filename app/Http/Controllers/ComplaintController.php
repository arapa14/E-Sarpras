<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Location;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Yajra\DataTables\Facades\DataTables;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apk = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        $locations = Location::all();

        $data = compact('user', 'apk', 'logo', 'locations');
        return view('user.complaint', $data);
    }

    /**
     * Proses gambar: tambahkan watermark dan simpan gambar ke storage.
     *
     * @param \Illuminate\Http\UploadedFile $imageFile
     * @param string $imageNamePrefix
     * @param string $directory
     * @param string $watermarkText
     * @param string $fontPath
     * @param int $sizeLimit (dalam KB)
     * @return string Path publik gambar yang telah disimpan
     */
    private function processImage($imageFile, $imageNamePrefix, $directory, $watermarkText, $fontPath, $sizeLimit = 1024)
    {
        // 1. Buat instance image manager dengan driver GD
        $manager = new ImageManager(new Driver);

        // 2. Tentukan nama file & path penyimpanan
        $uniqueId  = uniqid();
        $extension = $imageFile->getClientOriginalExtension();
        $imageName = $imageNamePrefix . '_' . time() . '_' . $uniqueId . '.' . $extension;
        $imagePath = storage_path("app/public/{$directory}/{$imageName}");;

        // 3. Baca gambar dengan Intervention Image
        $image = $manager->read($imageFile->getRealPath());
        $imgWidth  = $image->width();
        $imgHeight = $image->height();

        // 4. Definisikan batas watermark agar tidak menutupi foto
        //    - Maksimal 40% dari lebar gambar
        //    - Maksimal 20% dari tinggi gambar
        // Silakan sesuaikan persentase ini sesuai kebutuhan desain.
        $maxWatermarkWidth  = 0.4 * $imgWidth;
        $maxWatermarkHeight = 0.2 * $imgHeight;

        // 5. Margin luar (dari tepi gambar) dan padding dalam (di dalam rectangle)
        $margin  = 10;
        $padding = 10;

        // 6. Siapkan teks multi-baris
        $lines = explode("\n", $watermarkText);

        /**
         * 7. Cari ukuran font terbesar yang masih muat dalam batas
         *    Menggunakan pendekatan binary search agar lebih efisien.
         *    - Batas bawah (minFontSize) = 10
         *    - Batas atas (maxFontSize)  = 150 (silakan sesuaikan)
         */
        $minFontSize = 10;
        $maxFontSize = 150;
        $bestFontSize = $minFontSize; // nilai awal

        while ($minFontSize <= $maxFontSize) {
            $mid = (int) floor(($minFontSize + $maxFontSize) / 2);

            // Ukur bounding box teks dengan font size = $mid
            $textBox = $this->measureTextBox($lines, $fontPath, $mid);

            // Tambahkan padding untuk rectangle
            $watermarkW = $textBox['width']  + $padding * 2;
            $watermarkH = $textBox['height'] + $padding * 2;

            // Cek apakah muat dalam batas
            if ($watermarkW <= $maxWatermarkWidth && $watermarkH <= $maxWatermarkHeight) {
                // Masih muat -> perbesar font
                $bestFontSize = $mid;
                $minFontSize = $mid + 1;
            } else {
                // Terlalu besar -> perkecil font
                $maxFontSize = $mid - 1;
            }
        }

        // 8. Hitung ulang ukuran background watermark dengan bestFontSize
        $textBox   = $this->measureTextBox($lines, $fontPath, $bestFontSize);
        $watermarkW = $textBox['width']  + $padding * 2;
        $watermarkH = $textBox['height'] + $padding * 2;

        // 9. Tentukan posisi rectangle di pojok kanan-bawah
        $backgroundX = $imgWidth  - $watermarkW - $margin;
        $backgroundY = $imgHeight - $watermarkH - $margin;

        // 10. Gambar rectangle background watermark (Intervention Image v3.x)
        $image->drawRectangle($backgroundX, $backgroundY, function (RectangleFactory $rectangle) use ($watermarkW, $watermarkH) {
            $rectangle->size($watermarkW, $watermarkH);
            $rectangle->background('rgba(0, 0, 0, 0.5)'); // set semi-transparan
            $rectangle->border('white', 2);
        });

        // 11. Letakkan teks di pojok kanan-bawah rectangle
        $textX = $backgroundX + $watermarkW  - $padding;
        $textY = $backgroundY + $watermarkH - $padding;

        $image->text($watermarkText, $textX, $textY, function ($font) use ($fontPath, $bestFontSize) {
            $font->file($fontPath);
            $font->size($bestFontSize);
            $font->color('rgba(255, 255, 255, 0.9)');
            $font->align('right');
            $font->valign('bottom');
        });

        // 12. Pastikan direktori penyimpanan gambar ada
        if (!file_exists(storage_path("app/public/{$directory}"))) {
            mkdir(storage_path("app/public/{$directory}"), 0755, true);
        }

        // 13. Simpan gambar dengan kualitas awal 80%
        $quality = 80;
        $image->save($imagePath, $quality);

        // 14. Kompres gambar jika ukuran melebihi sizeLimit (dalam KB)
        while (filesize($imagePath) > $sizeLimit * 1024) {
            if ($quality <= 10) {
                break;
            }
            $quality -= 10;
            $image->save($imagePath, $quality);
        }

        // 15. Kembalikan path publik
        return "/{$directory}/{$imageName}";
    }

    /**
     * Helper untuk mengukur lebar dan tinggi total dari teks multi-baris.
     *
     * @param array $lines
     * @param string $fontPath
     * @param int $fontSize
     * @return array ['width' => int, 'height' => int]
     */
    private function measureTextBox(array $lines, string $fontPath, int $fontSize): array
    {
        $maxWidth = 0;
        $totalHeight = 0;
        $lineSpacing = 1.2; // spasi antar baris

        foreach ($lines as $index => $line) {
            $box = imagettfbbox($fontSize, 0, $fontPath, $line);
            $width  = abs($box[2] - $box[0]);
            $height = abs($box[1] - $box[5]);
            $maxWidth = max($maxWidth, $width);
            $totalHeight += ($index === 0) ? $height : $height * $lineSpacing;
        }

        return [
            'width'  => $maxWidth,
            'height' => $totalHeight,
        ];
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'before_image' => 'required|array|min:1',
            'before_image.*' => 'file|image|mimes:jpg,png,jpeg',
            'description' => 'required|string',
            'location' => 'required|string|not_in:Pilih lokasi',
            'suggestion' => 'required|string',
        ]);

        $user = Auth::user();
        $imagePaths = [];
        $imageNamePrefix = 'complain';
        $directory = 'complaints';

        if (!Storage::exists("public/{$directory}")) {
            Storage::makeDirectory("public/{$directory}");
        }

        $watermarkText = $user->name . " - " . now()->format('d/m/Y H:i:s');
        $fontPath = public_path('arial.ttf');

        // Proses semua gambar yang diunggah
        foreach ($request->file('before_image') as $imageFile) {
            $imagePath = $this->processImage($imageFile, $imageNamePrefix, $directory, $watermarkText, $fontPath);
            $imagePaths[] = $imagePath;
        }

        try {
            // Simpan data complaint ke database
            $complaint = new Complaint();
            $complaint->user_id = $user->id;
            $complaint->description = $request->input('description');
            $complaint->location = $request->input('location');
            $complaint->suggestion = $request->input('suggestion');
            $complaint->before_image = json_encode($imagePaths);
            $complaint->status = 'pending';
            $complaint->save();

            // Dispatch job untuk mengirim email secara asinkron
            dispatch(new \App\Jobs\SendComplaintCreatedEmail($user, $complaint, $imagePaths));

            return redirect()->back()->with('success', 'Berhasil mengirim komplain.');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->with('error', 'Gagal mengirim komplain.');
        }
    }

    public function riwayat()
    {
        $user = Auth::user();
        $apk = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;

        $data = compact('user', 'apk', 'logo');
        return view('user.history', $data);
    }

    // Menghandle AJAX request dari DataTables
    public function getRiwayat(Request $request)
    {
        $userId = Auth::id(); // Hanya ambil pengaduan milik user yang sedang login
        $history = Complaint::where('user_id', $userId)->orderBy('created_at', 'desc');

        return DataTables::of($history)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                // Gunakan Carbon untuk format tanggal, misal: 15 Mar 2025 14:30
                return Carbon::parse($row->created_at)->format('d M Y H:i');
            })
            ->editColumn('status', function ($row) {
                // Sesuaikan badge status berdasarkan nilai status di database
                $statusClass = match ($row->status) {
                    'pending'  => 'bg-yellow-100 text-yellow-700 border border-yellow-500',
                    'progress' => 'bg-blue-100 text-blue-700 border border-blue-500',
                    'selesai'  => 'bg-green-100 text-green-700 border border-green-500',
                    default    => 'bg-gray-100 text-gray-600'
                };
                return "<span class='px-3 py-1 $statusClass rounded-full text-xs font-semibold uppercase'>$row->status</span>";
            })
            ->addColumn('action', function ($row) {
                // Tombol untuk melihat semua gambar
                $images = json_decode($row->before_image, true);
                $imagesJson = htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8');
                $buttonImages = '<button class="action-icon btn-view p-2" onclick="openImagesModal(\'' . $imagesJson . '\')" title="Lihat Semua Gambar">
                                <i class="fa-solid fa-images"></i>
                             </button>';
                // Tombol untuk melihat detail laporan
                $buttonDetail = '<a href="' . route('complaint.detail', $row->id) . '" class="action-icon btn-detail p-2" title="Lihat Detail">
                    <i class="fa-solid fa-eye fa-lg"></i>
                 </a>';
                return '<div class="flex justify-center space-x-2">' . $buttonImages . $buttonDetail . '</div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $user = Auth::user();
        $apk = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        // Pastikan model Complaint memiliki relasi 'responses'
        $complaint->load('responses');

        $data = compact('user', 'apk', 'logo', 'complaint');
        return view('user.detail', $data);
    }

    // Admin Boundary


    public function complaintList()
    {
        return view('admin.complaintList');
    }


    public function getList(Request $request)
    {
        // Menggunakan eager load relasi user agar dapat mengakses properti user.name
        $list = Complaint::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'progress', 'selesai')")
            ->orderBy('created_at', 'asc');

        try {
            return DataTables::of($list)
                ->addIndexColumn()
                // Menambahkan kolom user_name berdasarkan relasi user
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    // Gunakan Carbon untuk format tanggal, misal: 15 Mar 2025 14:30
                    return Carbon::parse($row->created_at)->format('d M Y H:i');
                })
                ->editColumn('status', function ($row) {
                    $options = [
                        'pending'  => ['label' => 'Pending',  'class' => 'bg-yellow-100 text-yellow-700 border border-yellow-500'],
                        'progress' => ['label' => 'Progress', 'class' => 'bg-blue-100 text-blue-700 border border-blue-500'],
                        'selesai'  => ['label' => 'Selesai',  'class' => 'bg-green-100 text-green-700 border border-green-500'],
                    ];
                    $status = $row->status;
                    $label = $options[$status]['label'] ?? ucfirst($status);
                    $class = $options[$status]['class'] ?? '';
                    return "<span class='px-3 py-1 {$class} rounded-full text-xs font-semibold uppercase'>{$label}</span>";
                })
                ->addColumn('action', function ($row) {
                    // Tombol untuk melihat semua gambar dan detail laporan
                    $images = json_decode($row->before_image, true);
                    $imagesJson = htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8');
                    $buttonImages = '<button class="action-icon btn-view p-2" onclick="openImagesModal(\'' . $imagesJson . '\')" title="Lihat Semua Gambar">
                                    <i class="fa-solid fa-images"></i>
                                 </button>';
                    $buttonDetail = '<a href="' . route('complaint.list.detail', $row->id) . '" class="action-icon btn-detail p-2" title="Lihat Detail">
                                    <i class="fa-solid fa-eye fa-lg"></i>
                                 </a>';
                    return '<div class="flex justify-center space-x-2">' . $buttonImages . $buttonDetail . '</div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            // Lakukan log error
            \Log::error($e);
            // Mengembalikan respon error
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    public function detail(Complaint $complaint)
    {
        // Muat relasi user dan (jika ada) response jika diperlukan
        $complaint->load('user', 'responses');
        return view('admin.complaintDetail', compact('complaint'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
