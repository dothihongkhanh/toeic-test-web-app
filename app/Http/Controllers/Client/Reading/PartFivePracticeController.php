<?php

namespace App\Http\Controllers\Client\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;
use App\Services\ExamService;

class PartFivePracticeController extends Controller
{
    public function index()
    {
        $examsInPart5 = resolve(ExamService::class)->getExamsByPart(PartType::PartFive);

        return view('client.reading.part-five.index', compact('examsInPart5'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();
       

        return view('client.reading.part-five.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.reading.part-five.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}