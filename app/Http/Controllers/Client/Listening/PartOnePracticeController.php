<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;
use App\Services\ExamService;

class PartOnePracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart1 = resolve(ExamService::class)->getExamsByPart(PartType::PartOne);

        return view('client.listening.part-one.index', compact('examsInPart1'));
    }

    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('client.listening.part-one.detail', compact('exam', 'questions'));
    }

    public function showResultDetail(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();
        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $questions = $exam->questions()->get();

        return view('client.listening.part-one.detail_result', compact('userExam', 'exam', 'questions', 'userAnswers'));
    }
}
