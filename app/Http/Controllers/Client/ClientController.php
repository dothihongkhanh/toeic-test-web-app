<?php

namespace App\Http\Controllers\Client;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Part;
use App\Models\UserAnswer;
use App\Models\UserExam;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.home');
    }

    public function showPartListening()
    {
        $listeningParts = Part::where('id', 'like', PartType::PartOne)
            ->orWhere('id', 'like', PartType::PartTwo)
            ->orWhere('id', 'like', PartType::PartThree)
            ->orWhere('id', 'like', PartType::PartFour)
            ->get();

        return view('client.listening.index', compact('listeningParts'));
    }

    public function showPartReading()
    {
        $readingParts = Part::where('id', 'like', PartType::PartFive)
            ->orWhere('id', 'like', PartType::PartSix)
            ->orWhere('id', 'like', PartType::PartSeven)
            ->get();

        return view('client.reading.index', compact('readingParts'));
    }

    public function submit(Request $request)
    {
        $user = auth()->user();
        $answers = $request->input('answer');

        if (empty($answers)) {
            toastr()->error('Bạn chưa chọn đáp án nào. Vui lòng chọn trước khi nộp bài!');
            return redirect()->back();
        }

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

        $totalChildQuestions = 0;

        foreach ($exam->questions as $question) {
            $totalChildQuestions += $question->questionChilds()->count();
        }

        $totalSkipped = $totalChildQuestions - ($totalCorrect + $totalWrong);

        return view('client.result', compact('exam', 'userExam', 'totalCorrect', 'totalWrong', 'totalSkipped'));
    }
}
