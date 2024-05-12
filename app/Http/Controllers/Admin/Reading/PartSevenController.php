<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartSeven\CreatePartSevenRequest;
use App\Imports\PartSevenImport;
use App\Models\Exam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PartSevenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart7 = Exam::where('id_part', PartType::PartSeven)->get();

        return view('admin.reading.part-seven.index', compact('examsInPart7'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reading.part-seven.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartSevenRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $imageFiles = $request->file('image_upload');
            $import = new PartSevenImport($imageFiles);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 7 has been saved successfully!');
                return redirect()->route('list-part7');
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
