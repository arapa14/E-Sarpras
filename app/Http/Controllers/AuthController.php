<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        $name = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        return view('auth.login', compact('name', 'logo'));
    }
}
