<?php

namespace App\Imports;

use App\Enums\ExamType;
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

class PartOneImport implements ToModel, WithHeadingRow
{
    protected $levelId;
    protected $audioFiles;
    protected $imageFiles;
    protected $importSuccess;

    public function __construct($audioFiles, $imageFiles)
    {
        $this->audioFiles = $audioFiles;
        $this->imageFiles = $imageFiles;
        $this->importSuccess = false;
    }

    public function model(array $row)
    {
        if (empty($row['question_id']) || $row['question_id'] == 'question_id') {
            return null;
        }

        $parentQuestion = Question::where('code', $row['question_id'])->first();

        if (!$parentQuestion) {
            foreach ($this->audioFiles as $audioFile) {
                $audioName = $audioFile->getClientOriginalName();
                if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                    $idQuestionFromAudioName = $matches[1];
                    if ($row['question_id'] == $idQuestionFromAudioName) {
                        $audioPath = $audioFile->store('listening/part1/audios', 'public');

                        $exam = Exam::firstOrCreate([
                            'name_exam' => request()->input('name_practice'),
                            'price' => request()->input('price'),
                            'time' => null,
                            'id_part' => PartType::PartOne,
                        ]);

                        $parentQuestion = Question::create([
                            'code' => $row['question_id'],
                            'id_exam' => $exam->id,
                            'url_audio' => Storage::url($audioPath),
                            'transcript' => $row['transcript'],
                        ]);
                        break;
                    }
                }
            }
        }

        if ($parentQuestion) {
            foreach ($this->imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                    $idQuestionFromImageName = $matches[1];
                    if ($row['question_id'] == $idQuestionFromImageName) {
                        $imagePath = $imageFile->store('listening/part1/images', 'public');
                        Image::firstOrCreate([
                            'url_image' => Storage::url($imagePath),
                            'id_question' => $parentQuestion->id,
                        ]);
                        break;
                    }
                } else {
                    return null;
                }
            }

            $questionChild = QuestionChild::create([
                'id_question' => $parentQuestion->id,
                'question_number' => $row['question_number'],
                'question_title' => null,
                'explanation' => $row['explanation'],
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
