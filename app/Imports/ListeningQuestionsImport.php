<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Audio;
use App\Models\Image;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListeningQuestionsImport implements ToModel, WithHeadingRow
{
    protected $levelId, $partId;

    public function __construct($levelId, $partId)
    {
        $this->levelId = $levelId;
        $this->partId = $partId;
    }
    public function model(array $row)
    {
        $imageFiles = request()->file('image_upload');
        $audioFiles = request()->file('audio_upload');

        if ($imageFiles !== null && $audioFiles !== null && count($imageFiles) > 0 && count($audioFiles) > 0) {
            foreach ($imageFiles as $key => $imageFile) {
                $imageName = $imageFile->getClientOriginalName();

                if ($imageName === $row['image']) {
                    $audioFile = $audioFiles[$key];

                    $imagePath = $imageFile->store('listening/images', 'public');
                    $audioPath = $audioFile->store('listening/audios', 'public');

                    $image = Image::create(['url_image' => Storage::url($imagePath)]);
                    $audio = Audio::create(['url_audio' => Storage::url($audioPath)]);

                    $question = Question::create([
                        'question_title' => $row['question_title'],
                        'id_image' => $image->id,
                        'id_audio' => $audio->id,
                        'id_level' => $this->levelId,
                        'id_part' => $this->partId,
                    ]);

                    for ($j = 1; $j <= 4; $j++) {
                        Answer::create([
                            'id_question' => $question->id,
                            'answer_text' => $row['answer_' . $j],
                            'is_correct' => ($row['correct_answer'] === "Chọn đáp án " . chr(64 + $j)), // Sử dụng mã ASCII để chuyển đổi A, B, C, D thành 1, 2, 3, 4
                        ]);
                    }
                }
            }
        }
    }
}
