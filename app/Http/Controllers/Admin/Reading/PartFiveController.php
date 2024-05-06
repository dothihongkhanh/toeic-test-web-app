<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\ExamType;
use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartFive\CreatePartFiveRequest;
use App\Http\Requests\PartFour\CreatePartFourRequest;
use App\Imports\PartFiveImport;
use App\Imports\PartFourImport;
use App\Models\Level;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PartFiveController extends Controller
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
        $exams_in_part5 = DB::table('parts')
            ->select('exams.id', 'exams.name_exam', 'exams.price', 'levels.name_level')
            ->join('questions', 'parts.id', '=', 'questions.id_part')
            ->join('exam_questions', 'questions.id', '=', 'exam_questions.id_question')
            ->join('exams', 'exam_questions.id_exam', '=', 'exams.id')
            ->join('levels', 'exams.id_level', '=', 'levels.id')
            ->where('parts.id', PartType::PartFive)
            ->distinct()
            ->groupBy('exams.id', 'exams.name_exam', 'exams.price', 'levels.name_level')
            ->get();

        return view('admin.reading.part-five.index', compact('exams_in_part5'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = $this->getLevels();
        $types = $this->getTypes();
        foreach ($types as $type) {
            if ($type['id'] == ExamType::ReadingPractice) {
                $nameType = $type['name_type'];
            }
        }

        return view('admin.reading.part-five.create', compact('levels', 'nameType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartFiveRequest $request)
    {
        $levelId = $request->input('id_level');
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $import = new PartFiveImport($levelId);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 5 has been saved successfully!');
                return redirect()->route('list-part5');
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
