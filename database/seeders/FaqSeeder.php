<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu sarpras?',
                'answer' => 'Sarpras adalah singkatan dari Sarana Prasarana. Fasilitas atau alat yang diperlukan untuk mendukung suatu kegiatan atau aktivitas tertentu',
                'status' => 'published'
            ],
            [
                'question' => 'Siapa saja yang dapat mengakses aplikasi E-Sarpras?',
                'answer'   => 'Aplikasi E-Sarpras dapat diakses oleh staf, guru, dan pihak terkait lainnya di sekolah yang memiliki hak akses sesuai peran masing-masing.',
                'status'   => 'published'
            ],
            [
                'question' => 'Apa manfaat menggunakan E-Sarpras?',
                'answer'   => 'Manfaat penggunaan E-Sarpras adalah sebagai wadah keluhan masyarakat sekolah terkait sarana dan prasarana sekolah.',
                'status'   => 'published'
            ],
            [
                'question' => 'Bagaimana jika menemukan masalah atau bug pada aplikasi?',
                'answer'   => 'Jika menemukan masalah atau bug, pengguna dapat melaporkannya melalui fitur pertanyaan di bagian bawah.',
                'status'   => 'published'
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('faqs')->insert($faq);
        }
    }
}
