<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartTwoRequest;
use App\Imports\PartTwoImport;
use App\Models\Exam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PartTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart2 = Exam::where('id_part', PartType::PartTwo)->get();

        return view('admin.listening.part-two.index', compact('examsInPart2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-two.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartTwoRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');

            $import = new PartTwoImport($audioFiles);

            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 2 has been saved successfully!');
                return redirect()->route('list-part2');
            } else {
                toastr()->error('An error has occurred during import. Please select the correct file.');
                return redirect()->back();
            }
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
