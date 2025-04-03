<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengambil data nama aplikasi dan logo dari tabel setting
        $apk = Setting::where('key', 'name')->first()->value ?? 'Default App Name';
        $logo = Setting::where('key', 'logo')->first()->value ?? 'default-logo.png';

        // Membagikan data ke seluruh view
        View::share('apk', $apk);
        View::share('logo', $logo);
    }
}
