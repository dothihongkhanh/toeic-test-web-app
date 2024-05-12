<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartOneRequest;
use App\Imports\PartOneImport;
use App\Models\Exam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PartOneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart1 = Exam::where('id_part', PartType::PartOne)->get();

        return view('admin.listening.part-one.index', compact('examsInPart1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-one.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartOneRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');
            $imageFiles = $request->file('image_upload');

            $import = new PartOneImport($audioFiles, $imageFiles);
           
            $result = Excel::import($import, $file);
            
            if ($result && $import->importSuccess()) {
                toastr()->success('Part 1 has been saved successfully!');
                return redirect()->route('list-part1');
            } else {
                toastr()->error('An error has occurred during import. Please try again later.');
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
