<?php

namespace App\Http\Controllers\Client\Listening;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;

class ListeningPracticeController extends Controller
{
    protected $part;

    public function __construct(Part $part)
    {
        $this->part = $part;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listeningParts = $this->part::where('name_part', 'like', 'Part %')
            ->whereRaw('CAST(SUBSTRING(name_part, 6) AS UNSIGNED) BETWEEN 1 AND 4')
            ->get();

        return view('client.listening.index', compact('listeningParts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
