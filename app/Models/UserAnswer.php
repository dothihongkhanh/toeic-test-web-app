<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user_exam',
        'id_user_answer',
    ];

    public static function calculateResults($user, $exam)
    {
        $totalCorrect = 0;
        $totalWrong = 0;
        $totalSkipped = 0;
        $userAnswers = $user->answers()->where('exam_id', $exam->id)->get();

        foreach ($userAnswers as $userAnswer) {
            $isCorrect = Answer::where('id', $userAnswer->user_answer)->value('is_correct');
            if ($isCorrect) {
                $totalCorrect++;
            } else {
                $totalWrong++;
            }
        }

        $totalChildQuestions = 0;

        foreach ($exam->questions as $question) {
            $totalChildQuestions += $question->questionChilds()->count();
        }

        $totalSkipped = $totalChildQuestions - ($totalCorrect + $totalWrong);

        return [
            'totalChildQuestions' => $totalChildQuestions,
            'totalCorrect' => $totalCorrect,
            'totalWrong' => $totalWrong,
            'totalSkipped' => $totalSkipped
        ];
    }
}
