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

class PartSevenImport implements ToModel, WithHeadingRow
{
    protected $imageFiles;
    protected $importSuccess;

    public function __construct($imageFiles)
    {
        $this->imageFiles = $imageFiles;
        $this->importSuccess = true; // Initialize import success as true
    }

    public function model(array $row)
    {
        if (empty($row['code_part7']) || $row['code_part7'] == 'code_part7') {
            $this->importSuccess = false;
            return null;
        }

        // Check image files
        $imageValid = false;
        foreach ($this->imageFiles as $imageFile) {
            $imageName = $imageFile->getClientOriginalName();
            if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                $idQuestionFromImageName = $matches[1];
                if ($row['code_part7'] == $idQuestionFromImageName) {
                    $imageValid = true; // Image file format is valid
                    break;
                }
            }
        }

        // If image file format is invalid, stop importing and set importSuccess to false
        if (!$imageValid) {
            toastr()->error('Tên ảnh không đúng định dạng');
            $this->importSuccess = false;
            throw ValidationException::withMessages(['error' => 'Invalid file format']); // Throw exception to stop importing
        }

        // Proceed to create or update the question
        $parentQuestion = Question::where('id_part', PartType::PartSeven)
            ->where('code', $row['code_part7'])
            ->first();

        if (!$parentQuestion) {
            // Create new question if not exists
            foreach ($this->imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                    $idQuestionFromImageName = $matches[1];
                    if ($row['code_part7'] == $idQuestionFromImageName) {
                        $imagePath = $imageFile->store('reading/part7/images', 'public');
                        $parentQuestion = Question::create([
                            'code' => $row['code_part7'],
                            'id_part' => PartType::PartSeven,
                            'transcript' => $row['transcript'],
                        ]);
                        Image::firstOrCreate([
                            'id_question' => $parentQuestion->id,
                            'url_image' => Storage::url($imagePath),
                        ]);
                        break;
                    }
                }
            }
        }

        // Create question child and answers
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

        // If import success is true, return the parent question; otherwise, return null
        return $this->importSuccess ? $parentQuestion : null;
    }

    public function importSuccess()
    {
        return $this->importSuccess;
    }
}
