<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class serverController extends Controller
{
    public function getServerTime()
    {
        return response()->json([
            'time' => Carbon::now()->locale('id')->translatedFormat('l, d F Y H:i:s')
        ]);
    }
}
