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
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartThreeImport implements ToModel, WithHeadingRow
{
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
        if (empty($row['code_part3']) || $row['code_part3'] == 'code_part3') {
            $this->importSuccess = false;
            return null;
        }

        // Check audio files
        $audioValid = false;
        foreach ($this->audioFiles as $audioFile) {
            $audioName = $audioFile->getClientOriginalName();
            if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                $idQuestionFromAudioName = $matches[1];
                if ($row['code_part3'] == $idQuestionFromAudioName) {
                    $audioValid = true; // Audio file format is valid
                    break;
                }
            }
        }

        // Check image files
        $imageValid = false;
        if (isset($row['image_name']) && !empty($row['image_name'])) {
            foreach ($this->imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                    $idQuestionFromImageName = $matches[1];
                    if ($row['code_part3'] == $idQuestionFromImageName) {
                        $imageValid = true;
                        break;
                    }
                }
            }
        } else {
            $imageValid = true;
        }

        // If any file format is invalid, stop importing and set importSuccess to false
        if (!$audioValid || !$imageValid) {
            if (!$audioValid) {
                toastr()->error('Tên audio không đúng định dạng');
            }
            if (!$imageValid) {
                toastr()->error('Tên ảnh không đúng định dạng');
            }
            $this->importSuccess = false;
            throw ValidationException::withMessages(['error' => 'Invalid file format']); // Throw exception to stop importing
        }

        $parentQuestion = Question::where('id_part', PartType::PartThree)
            ->where('code', $row['code_part3'])
            ->first();

        if (!$parentQuestion) {
            foreach ($this->audioFiles as $audioFile) {
                $audioName = $audioFile->getClientOriginalName();
                if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                    $idQuestionFromAudioName = $matches[1];
                    if ($row['code_part3'] == $idQuestionFromAudioName) {
                        $audioPath = $audioFile->store('listening/part3/audios', 'public');
                        $parentQuestion = Question::create([
                            'code' => $row['code_part3'],
                            'id_part' => PartType::PartThree,
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
                    if ($row['code_part3'] == $idQuestionFromImageName) {
                        $imagePath = $imageFile->store('listening/part3/images', 'public');
                        $existingImage = Image::where('id_question', $parentQuestion->id)->first();

                        if ($existingImage) {
                            $existingImage->update([
                                'url_image' => Storage::url($imagePath),
                            ]);
                        } else {
                            Image::create([
                                'url_image' => Storage::url($imagePath),
                                'id_question' => $parentQuestion->id,
                            ]);
                        }
                        break;
                    }
                } else {
                    return null;
                }
            }

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
