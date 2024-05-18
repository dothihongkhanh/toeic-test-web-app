<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;

class PartFourPracticeController extends Controller
{
    public function index()
    {
        $part4 = Part::where('id', PartType::PartFour)->first();
        $examsInPart4 = $part4->exams()->get();

        return view('client.listening.part-four.index', compact('examsInPart4'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.listening.part-four.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.listening.part-four.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}
