<?php

namespace App\Http\Controllers\Client;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Part;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserExam;
use App\Services\AiAnalysisService;
use App\Traits\CalculateResultTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    use CalculateResultTrait;

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

    // public function calculateResults($userAnswers, $exam)
    // {
    //     $totalCorrect = 0;
    //     $totalWrong = 0;
    //     $totalSkipped = 0;


    //     foreach ($userAnswers as $userAnswer) {
    //         $isCorrect = Answer::where('id', $userAnswer->id_user_answer)->value('is_correct');
    //         if ($isCorrect) {
    //             $totalCorrect++;
    //         } else {
    //             $totalWrong++;
    //         }
    //     }

    //     $totalChildQuestions = 0;

    //     foreach ($exam->questions as $question) {
    //         $totalChildQuestions += $question->questionChilds()->count();
    //     }

    //     $totalSkipped = $totalChildQuestions - ($totalCorrect + $totalWrong);

    //     return [
    //         'totalChildQuestions' => $totalChildQuestions,
    //         'totalCorrect' => $totalCorrect,
    //         'totalWrong' => $totalWrong,
    //         'totalSkipped' => $totalSkipped
    //     ];
    // }

    public function showResult(string $id)
    {
        $userExam = UserExam::findOrFail($id);
        $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();

        $exam = Exam::findOrFail($userExam->id_exam);

        $results = $this->calculateResults($userAnswers, $exam);

        return view('client.result', compact('exam', 'userExam'))->with($results);
    }

    public function showHistory(string $examId)
    {
        $exam = Exam::findOrFail($examId);
        $userExams = UserExam::where('id_exam', $examId)
            ->where('id_user', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        $resultsArray = [];
        foreach ($userExams as $userExam) {
            $userAnswers = UserAnswer::where('id_user_exam', $userExam->id)->get();

            $totalChildQuestions = 0;
            $wrongQuestionChildIds = [];
            foreach ($exam->questions as $question) {
                $totalChildQuestions += $question->questionChilds()->count();
                foreach ($question->questionChilds as $questionChild) {
                    foreach ($questionChild->answers as $answer) {
                        if ($userAnswers->contains('id_user_answer', $answer->id)) {
                            if (!$answer->is_correct) {
                                $wrongQuestionChildIds[] = $questionChild->id;
                            }
                        }
                    }
                }
            }

            $results = $this->calculateResults($userAnswers, $exam);
            $resultsArray[] = [
                'date' => $userExam->date,
                'idUserExam' => $userExam->id,
                'total_time' => $userExam->total_time,
                'totalCorrect' => $results['totalCorrect'],
                'totalChildQuestions' => $totalChildQuestions,
                'wrongQuestionChildIds' => $wrongQuestionChildIds,
            ];
        }

        return view('client.history', compact('exam', 'userExams', 'resultsArray'));
    }

    public function showPart()
    {
        $listeningParts = Part::where('id', 'like', PartType::PartOne)
            ->orWhere('id', 'like', PartType::PartTwo)
            ->orWhere('id', 'like', PartType::PartThree)
            ->orWhere('id', 'like', PartType::PartFour)
            ->get();

        $readingParts = Part::where('id', 'like', PartType::PartFive)
            ->orWhere('id', 'like', PartType::PartSix)
            ->orWhere('id', 'like', PartType::PartSeven)
            ->get();

        return view('client.part.index', compact('listeningParts', 'readingParts'));
    }

    public function showProfile()
    {
        $user = Auth::user();

        return view('client.profile', compact('user'));
    }

    public function showAnalytics($idUserExam)
    {
        $user = Auth::user();
        $results = [];

        $userAnswers = UserAnswer::where('id_user_exam', $idUserExam)->get();

        foreach ($userAnswers as $userAnswer) {
            // Lấy thông tin của Answer
            $answer = Answer::with('questionChild')->find($userAnswer->id_user_answer);
            if ($answer) {
                $questionChild = $answer->questionChild;
                $isCorrect = $answer->is_correct;
                $question = $questionChild->question;
                $images = $question->images;

                $imageUrls = [];
                foreach ($images as $image) {
                    $imageUrls[] = $image->url_image;
                }

                $results[] = [
                    "Images" => $imageUrls ?? 'N/A',
                    "Audio" => $question->url_audio ?? 'N/A',
                    "Number question" => $questionChild->question_number,
                    "QuestionChild" => $questionChild->question_title ?? 'N/A',
                    "Chosen Answer" => $answer->answer_text,
                    "Is Correct" => $isCorrect ? "true" : "false",
                ];
            }
        }

        try {
            $analysis = resolve(AiAnalysisService::class)->analyzeResults($results);
            if (isset($analysis['candidates'][0]['content']['parts'][0]['text'])) {
                $textAnalysis = $analysis['candidates'][0]['content']['parts'][0]['text'];

                $userExam = UserExam::find($idUserExam)->first();
                if ($userExam) {
                    $userExam->analysis = $textAnalysis;
                    $userExam->save();
                }
            } else {
                $textAnalysis = 'Có lỗi trong quá trình phân tích. Vui lòng thử lại!';
            }

            return view('client.analytics', compact('textAnalysis', 'user'));
        } catch (\Exception $e) {
            return view('client.analytics')->with('error', $e->getMessage());
        }
    }
}
