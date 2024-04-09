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

        if ($imageFiles) {
            foreach ($imageFiles as $imageFile) {
                $imagePath = $imageFile->store('listening/images', 'public');
                $image = new Image();
                $image->url_image = Storage::url($imagePath);
                $image->save();
            }
        }

        $audioFiles = request()->file('audio_upload');

        if ($audioFiles) {
            foreach ($audioFiles as $audioFile) {
                $audioPath = $audioFile->store('listening/audios', 'public');
                $audio = new Audio();
                $audio->url_audio = Storage::url($audioPath);
                $audio->save();
            }
        }

        // Lưu thông tin vào database

        $question = new Question();
        $question->question_title = $row['question_title'];
        $question->id_image = $image->id;
        $question->id_audio = $audio->id;
        $question->id_level = $this->levelId;
        $question->id_part = $this->partId;
        $question->save();

        for ($i = 1; $i <= 4; $i++) {
            $answer = new Answer();
            $answer->id_question = $question->id;
            $answer->answer_text = $row['answer_' . $i];
            $answer->is_correct = ($row['correct_answer'] === substr($answer->answer_text, 0, 1));
            $answer->save();
        }
    }
}
