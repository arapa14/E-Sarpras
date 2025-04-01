<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'name',
                'value' => 'E-Sarpras'
            ],
            [
                'key' => 'logo',
                'value' => 'storage/logos/E-Sarpras.jpg'
            ],
            [
                'key' => 'main_image',
                'value' => 'storage/logos/e-sarpras-landing.png'
            ]
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
