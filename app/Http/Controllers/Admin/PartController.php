<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
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
        $parts = $this->part->oldest('id')->get();
        return view('admin.part.index', compact('parts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.part.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_part' => 'required|unique:parts',
            'direction' => 'required',
            'desc' => 'required',
            'number_question' => 'required',
        ]);

        $part = Part::create([
            'name_part' => $request->input('name_part'),
            'direction' => $request->input('direction'),
            'desc' => $request->input('desc'),
            'number_question' => $request->input('number_question'),
        ]);

        if ($part instanceof Part) {
            toastr()->success('Partđã được lưu thành công!');

            return redirect()->route('admin.parts.list');
        }

        toastr()->error('Đã xảy ra lỗi, vui lòng thử lại sau.');

        return redirect()->back();
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
        try {
            $part = $this->part->findOrFail($id);
            return view('admin.part.update', compact('part'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            toastr()->error('Part not found.');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_part' => 'required|unique:parts,name_part,' . $id,
            'direction' => 'required',
            'desc' => 'required',
            'number_question' => 'required',
        ]);

        try {
            $part = $this->part->findOrFail($id);

            $part->name_part = $request->input('name_part');
            $part->direction = $request->input('direction');
            $part->desc = $request->input('desc');
            $part->number_question = $request->input('number_question');

            $part->save();

            toastr()->success('Part updated successfully.');
            return redirect()->route('admin.parts.list');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            toastr()->error('Part not found.');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $part = $this->part->findOrFail($id);
            if (!$part) {
                toastr()->error('Part not found.');
                return redirect()->back();
            }

            $part->delete();
            toastr()->success('Part deleted successfully.');
            return redirect()->route('admin.parts.list');
        } catch (\Exception $e) {
            toastr()->error('An error occurred while deleting the part.');
            return redirect()->back();
        }
    }
}
