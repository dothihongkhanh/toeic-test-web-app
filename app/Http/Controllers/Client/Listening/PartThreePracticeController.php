<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;

class PartThreePracticeController extends Controller
{
    public function index()
    {
        $examsInPart3 = Exam::where('id_part', PartType::PartThree)->get();

        return view('client.listening.part-three.index', compact('examsInPart3'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.listening.part-three.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.listening.part-three.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}
