<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartOnePracticeController extends Controller
{
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
            ->join('levels', 'exams.id_level', '=', 'levels.id')
            ->where('parts.id', PartType::PartOne)
            ->distinct()
            ->groupBy('exams.id', 'exams.name_exam', 'exams.price', 'levels.name_level')
            ->get();

        return view('client.listening.part-one.index', compact('exams_in_part1'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.listening.part-one.detail', compact('exam', 'questions'));
    }

    public function submit(Request $request)
    {
        

    }
}
