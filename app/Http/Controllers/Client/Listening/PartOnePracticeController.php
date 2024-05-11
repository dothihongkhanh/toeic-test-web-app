<?php

namespace App\Http\Controllers\Client\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\UserAnswer;
use App\Models\UserExam;
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
        $user = auth()->user();
        $answers = $request->input('answer');

        $userExam = UserExam::create([
            'id_user' => $user->id,
            'id_exam' => $request->input('idExam'),
            'date' => now(),
            'total_time' => $request->input('timeElapsed'),
        ]);

        foreach ($answers as $questionId => $answerId) {
            UserAnswer::firstOrCreate([
                'id_user_exam' => $userExam->id,
                'id_user_answer' => $answerId,
            ]);
        }

        return redirect()->route('result', ['id' => $userExam->id]);
        // return redirect()->route('result.detail', ['id' => $idExam]);
    }

    public function showResult(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();

        $totalCorrect = 0;
        $totalWrong = 0;

        foreach ($userAnswers as $userAnswer) {
            $isCorrect = Answer::where('id', $userAnswer->id_user_answer)->value('is_correct');
            if ($isCorrect) {
                $totalCorrect++;
            } else {
                $totalWrong++;
            }
        }

        $idExam = $userExam->id_exam;
        $exam = Exam::findOrFail($idExam);
        $totalQuestions = $exam->questions->count();
        $totalSkipped = $totalQuestions - ($totalCorrect + $totalWrong);
        return view('client.result', compact('exam', 'userExam', 'totalCorrect', 'totalWrong', 'totalSkipped'));
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
