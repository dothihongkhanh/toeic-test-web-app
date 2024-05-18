<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartSix\CreatePartSixRequest;
use App\Imports\PartSixImport;
use App\Models\Part;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PartSixController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $part6 = Part::where('id', PartType::PartSix)->first();
        $examsInPart6 = $part6->exams()->get();

        return view('admin.reading.part-six.index', compact('examsInPart6'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reading.part-six.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartSixRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $imageFiles = $request->file('image_upload');
            $import = new PartSixImport($imageFiles);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 6 has been saved successfully!');
                return redirect()->route('list-part6');
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
