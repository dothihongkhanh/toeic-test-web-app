<?php

namespace App\Http\Controllers\Client\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;

class PartSevenPracticeController extends Controller
{
    public function index()
    {
        $part7 = Part::where('id', PartType::PartSeven)->first();
        $examsInPart7 = $part7->exams()->get();

        return view('client.reading.part-seven.index', compact('examsInPart7'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.reading.part-seven.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.reading.part-seven.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}