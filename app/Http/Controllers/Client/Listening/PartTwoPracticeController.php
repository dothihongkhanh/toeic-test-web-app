<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;

class PartTwoPracticeController extends Controller
{
    public function index()
    {
        $part2 = Part::where('id', PartType::PartTwo)->first();
        $examsInPart2 = $part2->exams()->get();

        return view('client.listening.part-two.index', compact('examsInPart2'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.listening.part-two.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.listening.part-two.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}
