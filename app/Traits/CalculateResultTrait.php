<?php

namespace App\Traits;

use App\Models\Answer;

trait CalculateResultTrait
{
    public function calculateResults($userAnswers, $exam)
    {
        $totalCorrect = 0;
        $totalWrong = 0;
        $totalSkipped = 0;

        foreach ($userAnswers as $userAnswer) {
            $isCorrect = Answer::where('id', $userAnswer->id_user_answer)->value('is_correct');
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