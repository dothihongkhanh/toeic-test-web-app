<?php

namespace App\Imports;

use App\Enums\PartType;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\QuestionChild;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartFiveImport implements ToModel, WithHeadingRow
{
    protected $importSuccess;

    public function __construct()
    {
        $this->importSuccess = false;
    }

    public function model(array $row)
    {
        if (empty($row['code_part5']) || $row['code_part5'] == 'code_part5') {
            $this->importSuccess = false;
            return null;
        }

        $parentQuestion = Question::where('id_part', PartType::PartFive)
            ->where('code', $row['code_part5'])
            ->first();

        if (!$parentQuestion) {
            $parentQuestion = Question::create([
                'code' => $row['code_part5'],
                'id_part' => PartType::PartFive,
                'url_audio' => null,
                'transcript' => null,
            ]);
        }

        if ($parentQuestion) {
            $questionChild = QuestionChild::firstOrCreate([
                'id_question' => $parentQuestion->id,
                'question_number' => $row['question_number'],
                'question_title' => $row['title_question'],
                'explanation' => $row['explanation'],
            ]);

            $exam = Exam::firstOrCreate([
                'name_exam' => request()->input('name_practice'),
                'price' => request()->input('price'),
                'time' => null,
            ]);

            ExamQuestion::firstOrCreate([
                'id_exam' => $exam->id,
                'id_question' => $parentQuestion->id,
            ]);

            for ($i = 1; $i <= 4; $i++) {
                Answer::firstOrCreate([
                    'id_question_child' => $questionChild->id,
                    'answer_text' => $row['answer' . $i],
                    'is_correct' => ($row['correct_answer'] == chr(64 + $i)),
                ]);
            }

            $this->importSuccess = true;

            return $parentQuestion;
        }

        return null;
    }

    public function importSuccess()
    {
        return $this->importSuccess;
    }
}
