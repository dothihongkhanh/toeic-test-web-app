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
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartOneImport implements ToModel, WithHeadingRow
{
    protected $audioFiles;
    protected $imageFiles;
    protected $importSuccess;

    public function __construct($audioFiles, $imageFiles)
    {
        $this->audioFiles = $audioFiles;
        $this->imageFiles = $imageFiles;
        $this->importSuccess = true; // Initialize import success as true
    }

    public function model(array $row)
    {
        if (empty($row['code_part1']) || $row['code_part1'] == 'code_part1') {
            $this->importSuccess = false;
            return null;
        }

        // Check audio files
        $audioValid = false;
        foreach ($this->audioFiles as $audioFile) {
            $audioName = $audioFile->getClientOriginalName();
            if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                $idQuestionFromAudioName = $matches[1];
                if ($row['code_part1'] == $idQuestionFromAudioName) {
                    $audioValid = true; // Audio file format is valid
                    break;
                }
            }
        }

        // Check image files
        $imageValid = false;
        foreach ($this->imageFiles as $imageFile) {
            $imageName = $imageFile->getClientOriginalName();
            if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                $idQuestionFromImageName = $matches[1];
                if ($row['code_part1'] == $idQuestionFromImageName) {
                    $imageValid = true; // Image file format is valid
                    break;
                }
            }
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

        // If all file formats are valid, proceed to create or update the question
        $parentQuestion = Question::where('id_part', PartType::PartOne)
            ->where('code', $row['code_part1'])
            ->first();

        if (!$parentQuestion) {
            // Create new question if not exists
            foreach ($this->audioFiles as $audioFile) {
                $audioName = $audioFile->getClientOriginalName();
                if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                    $idQuestionFromAudioName = $matches[1];
                    if ($row['code_part1'] == $idQuestionFromAudioName) {
                        $audioPath = $audioFile->store('listening/part1/audios', 'public');
                        $parentQuestion = Question::create([
                            'code' => $row['code_part1'],
                            'id_part' => PartType::PartOne,
                            'url_audio' => Storage::url($audioPath),
                            'transcript' => $row['transcript'],
                        ]);
                        break;
                    }
                }
            }
        }

        // Create or update image if valid
        foreach ($this->imageFiles as $imageFile) {
            $imageName = $imageFile->getClientOriginalName();
            if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                $idQuestionFromImageName = $matches[1];
                if ($row['code_part1'] == $idQuestionFromImageName) {
                    $imagePath = $imageFile->store('listening/part1/images', 'public');
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
            }
        }

        // Create question child and answers
        $questionChild = QuestionChild::firstOrCreate([
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

        for ($i = 1; $i <= 4; $i++) {
            Answer::firstOrCreate([
                'id_question_child' => $questionChild->id,
                'answer_text' => $row['answer' . $i],
                'is_correct' => ($row['correct_answer'] == chr(64 + $i)),
            ]);
        }

        // If import success is true, return the parent question; otherwise, return null
        return $this->importSuccess ? $parentQuestion : null;
    }

    public function importSuccess()
    {
        return $this->importSuccess;
    }
}
