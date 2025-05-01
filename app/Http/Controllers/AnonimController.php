<?php

namespace App\Http\Controllers;

use App\Models\Anonim;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AnonimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $name = Setting::where('key', 'name')->first()->value;
        $logo = Setting::where('key', 'logo')->first()->value;
        return view('anonim.anonim', compact('name', 'logo'));
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
    public function store(Request $request)
    {
        // Validate inputs
        $data = $request->validate([
            'description'  => 'required|string',
            'location'     => 'required|string',
            'suggestion'   => 'nullable|string',
            'before_image' => 'nullable|image|max:2048',
        ]);

        // Generate a unique ticket code
        $data['ticket'] = strtoupper(Str::random(8));

        // Handle file upload if present
        if ($request->hasFile('before_image')) {
            $data['before_image'] = $request->file('before_image')
                ->store('anonim_images', 'public');
        }

        // Create the record
        Anonim::create($data);

        // Redirect back with success message (including the ticket code)
        return back()->with('success', "Laporan terkirim! Kode Tiket Anda: {$data['ticket']}");
    }

    /**
     * Check report status by ticket code.
     */
    public function checkStatus(Request $request)
    {
        // Validate the ticket input
        $request->validate([
            'ticket' => 'required|string',
        ]);

        // Retrieve the report by ticket
        $anonim = Anonim::where('ticket', $request->ticket)->first();

        $name = Setting::where('key', 'name')->value('value');
        $logo = Setting::where('key', 'logo')->value('value');

        // Show the status view
        return view('anonim.status', compact('anonim', 'name', 'logo'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Anonim $anonim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anonim $anonim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anonim $anonim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anonim $anonim)
    {
        //
    }
}
