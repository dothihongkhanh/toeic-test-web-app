<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ListeningQuestionsImport;
use App\Models\Part;
use Illuminate\Http\Request;
use App\Models\Level;
use Maatwebsite\Excel\Facades\Excel;

class ListeningController extends Controller
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
        return view('admin.listening.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listeningParts = $this->part::where('name_part', 'like', 'Part %')
            ->whereRaw('CAST(SUBSTRING(name_part, 6) AS UNSIGNED) BETWEEN 1 AND 4')
            ->get();

        $levels = Level::get(['id', 'name_level']);
        return view('admin.listening.create', compact('listeningParts', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $levelId = $request->input('id_level');
        $partId = $request->input('id_part');


        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');

            Excel::import(new ListeningQuestionsImport($levelId, $partId), $file);

            toastr()->success('Listening has been saved successfully!');
            return redirect()->route('admin.listening.list');
        } else {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->back();
        }
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
