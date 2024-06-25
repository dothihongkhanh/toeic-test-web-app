<?php

namespace App\Imports;

use App\Enums\PartType;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\QuestionChild;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartTwoImport implements ToModel, WithHeadingRow
{
    protected $audioFiles;
    protected $importSuccess;

    public function __construct($audioFiles)
    {
        $this->audioFiles = $audioFiles;
        $this->importSuccess = false;
    }

    public function model(array $row)
    {
        if (empty($row['question_id']) || $row['question_id'] == 'question_id') {
            return null;
        }

        $parentQuestion = Question::where('id_part', PartType::PartTwo)
            ->where('code', $row['question_id'])
            ->first();

        if (!$parentQuestion) {
            foreach ($this->audioFiles as $audioFile) {
                $audioName = $audioFile->getClientOriginalName();
                if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                    $idQuestionFromAudioName = $matches[1];
                    if ($row['question_id'] == $idQuestionFromAudioName) {
                        $audioPath = $audioFile->store('listening/part2/audios', 'public');
                        $parentQuestion = Question::create([
                            'code' => $row['question_id'],
                            'id_part' => PartType::PartTwo,
                            'url_audio' => Storage::url($audioPath),
                            'transcript' => $row['transcript'],
                        ]);
                        break;
                    }
                }
            }
        }

        if ($parentQuestion) {
            $questionChild = QuestionChild::create([
                'id_question' => $parentQuestion->id,
                'question_number' => $row['question_number'],
                'question_title' => null,
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

            for ($i = 1; $i <= 3; $i++) {
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
