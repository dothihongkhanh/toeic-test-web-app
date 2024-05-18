<?php

namespace App\Http\Controllers\Client\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;

class PartSixPracticeController extends Controller
{
    public function index()
    {
        $part6 = Part::where('id', PartType::PartSix)->first();
        $examsInPart6 = $part6->exams()->get();

        return view('client.reading.part-six.index', compact('examsInPart6'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.reading.part-six.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.reading.part-six.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}
