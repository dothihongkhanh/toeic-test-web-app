<?php

namespace App\Imports;

use App\Enums\PartType;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Image;
use App\Models\Question;
use App\Models\QuestionChild;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartSevenImport implements ToModel, WithHeadingRow
{
    protected $imageFiles;
    protected $importSuccess;

    public function __construct($imageFiles)
    {
        $this->imageFiles = $imageFiles;
        $this->importSuccess = false;
    }

    public function model(array $row)
    {
        if (empty($row['question_id']) || $row['question_id'] == 'question_id') {
            return null;
        }

        $parentQuestion = Question::where('id_part', PartType::PartSeven)
            ->where('code', $row['question_id'])
            ->first();

        if (!$parentQuestion) {
            foreach ($this->imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                    $idQuestionFromImageName = $matches[1];
                    if ($row['question_id'] == $idQuestionFromImageName) {
                        $imagePath = $imageFile->store('reading/part7/images', 'public');
                        $parentQuestion = Question::firstOrCreate([
                            'code' => $row['question_id'],
                            'id_part' => PartType::PartSeven,
                            'url_audio' => null,
                            'transcript' => $row['transcript'],
                        ]);
                        Image::firstOrCreate([
                            'id_question' => $parentQuestion->id,
                            'url_image' => Storage::url($imagePath),                            
                        ]);
                    }
                } else {
                    return  null;
                }
            }
        }

        if ($parentQuestion) {
            $questionChild = QuestionChild::create([
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
