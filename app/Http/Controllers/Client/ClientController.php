<?php

namespace App\Http\Controllers\Client;

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
        $listeningParts = Part::where('name_part', 'like', 'Part %')
            ->whereRaw('CAST(SUBSTRING(name_part, 6) AS UNSIGNED) BETWEEN 1 AND 4')
            ->get();

        return view('client.listening.index', compact('listeningParts'));
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
        $totalQuestions = $exam->questions->count();
        $totalSkipped = $totalQuestions - ($totalCorrect + $totalWrong);

        return view('client.result', compact('exam', 'userExam', 'totalCorrect', 'totalWrong', 'totalSkipped'));
    }
}
