<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartOneRequest;
use App\Imports\PartOneImport;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PartOneController extends Controller
{
    protected function getLevels()
    {
        return Level::get(['id', 'name_level']);
    }

    protected function getTypes()
    {
        return Type::get(['id', 'name_type']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams_in_part1 = DB::table('parts')
            ->select('exams.id', 'exams.name_exam', 'exams.price', 'levels.name_level')
            ->join('questions', 'parts.id', '=', 'questions.id_part')
            ->join('exam_questions', 'questions.id', '=', 'exam_questions.id_question')
            ->join('exams', 'exam_questions.id_exam', '=', 'exams.id')
            ->join('levels', 'exams.id_level', '=', 'levels.id') // Thêm mối quan hệ với bảng levels
            ->where('parts.id', PartType::PartOne)
            ->distinct()
            ->groupBy('exams.id', 'exams.name_exam', 'exams.price', 'levels.name_level')
            ->get();

        return view('admin.listening.part-one.index', compact('exams_in_part1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = $this->getLevels();
        $types = $this->getTypes();
        foreach ($types as $type) {
            if ($type['id'] == 1) {
                $nameType = $type['name_type'];
            }
        }

        return view('admin.listening.part-one.create', compact('levels', 'nameType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartOneRequest $request)
    {
        $levelId = $request->input('id_level');
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');
            $imageFiles = $request->file('image_upload');

            $import = new PartOneImport($levelId, $audioFiles, $imageFiles);
           
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
