<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Audio;
use App\Models\Image;
use App\Models\ImageQuestion;
use App\Models\Question;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartOneImport implements ToModel, WithHeadingRow
{
    protected $levelId;
    protected $audioFiles;
    protected $imageFiles;

    public function __construct($levelId, $audioFiles, $imageFiles)
    {
        $this->levelId = $levelId;
        $this->audioFiles = $audioFiles;
        $this->imageFiles = $imageFiles;
    }

    public function model(array $row)
    {
        $level = $this->levelId;
        $question = null;

        // Tạo mới câu hỏi và lưu ID vào biến $question
        foreach ($this->audioFiles as $audioFile) {
            $audioName = $audioFile->getClientOriginalName();
            preg_match('/(\d+)_audio_/', $audioName, $matches);
            $idQuestionFromAudioName = $matches[1];
            if ($row['question_id'] == $idQuestionFromAudioName) {
                $audioPath = $audioFile->store('listening/part1/audios', 'public');
                $audio = Audio::create(['url_audio' => Storage::url($audioPath)]);
                $question = Question::create([
                    'id_part' => 1,
                    'id_level' => $level,
                    'question_number' => $row['question_number'],
                    'question_title' => null,
                    'transcript' => $row['transcript'],
                    'explanation' => $row['explanation'],
                    'id_audio' => $audio->id,
                ]);
            }
        }

        // Lưu ID của hình ảnh vào bảng trung gian question_image
        if ($question) {
            foreach ($this->imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                preg_match('/(\d+)_image_/', $imageName, $matches);
                $idQuestionFromImageName = $matches[1];
                if ($row['question_id'] == $idQuestionFromImageName) {
                    $imagePath = $imageFile->store('listening/part1/images', 'public');
                    $image = Image::create(['url_image' => Storage::url($imagePath)]);
                    ImageQuestion::create([
                        'id_image' => $image->id,
                        'id_question' => $question->id,
                    ]);
                }
            }
        }

        // Tạo mới các đáp án và lưu vào cơ sở dữ liệu
        if ($question) {
            for ($i = 1; $i <= 4; $i++) {
                Answer::create([
                    'id_question' => $question->id,
                    'answer_text' => $row['answer' . $i],
                    'is_correct' => ($row['correct_answer'] == chr(64 + $i)),
                ]);
            }
        }

        return $question;
    }
}
