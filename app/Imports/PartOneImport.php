<?php

namespace App\Imports;

use App\Enums\ExamType;
use App\Enums\PartType;
use App\Models\Answer;
use App\Models\Audio;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Image;
use App\Models\ImageQuestion;
use App\Models\Question;
use App\Models\Transcript;
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
    protected $importSuccess;

    public function __construct($levelId, $audioFiles, $imageFiles)
    {
        $this->levelId = $levelId;
        $this->audioFiles = $audioFiles;
        $this->imageFiles = $imageFiles;
        $this->importSuccess = false;
    }

    public function model(array $row)
    {
        /* Bỏ qua dòng tiêu đề  **/
        if ($row['question_id'] == 'question_id' || empty($row['question_id'])) {
            return null;
        }

        $level = $this->levelId;
        $exam = Exam::firstOrCreate([
            'name_exam' => request()->input('name_practice'),
            'price' => request()->input('price'),
            'time' => null,
            'id_type' => ExamType::ListeningPractice,
            'id_level' => $level,
        ]);

        $question = null;
        foreach ($this->audioFiles as $audioFile) {
            $audioName = $audioFile->getClientOriginalName();
            if (strpos($audioName, '/(\d+)_audio_/') !== false) {
                preg_match('/(\d+)_audio_/', $audioName, $matches);
                $idQuestionFromAudioName = $matches[1];
                if ($row['question_id'] == $idQuestionFromAudioName) {
                    // Logic xử lý khi 'question_id' trùng khớp
                    $audioPath = $audioFile->store('listening/part1/audios', 'public');
                    $audio = Audio::create(['url_audio' => Storage::url($audioPath)]);
                    $transcript = Transcript::create(['content_trans' => $row['transcript']]);
                    $question = Question::create([
                        'id_part' => PartType::PartOne,
                        'question_number' => $row['question_number'],
                        'question_title' => null,
                        'explanation' => $row['explanation'],
                        'id_audio' => $audio->id,
                        'id_trans' => $transcript->id,
                    ]);

                    ExamQuestion::create([
                        'id_exam' => $exam->id,
                        'id_question' => $question->id,
                    ]);
                } else {
                    return null; // Trả về null nếu 'question_id' không trùng khớp
                }
            } else {
                return null; // Trả về null nếu tên tệp không chứa 'question_id'
            }
        }

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
        } else {
            return null; // Trả về null nếu tên tệp không chứa 'question_id'
        }

        if ($question) {
            for ($i = 1; $i <= 4; $i++) {
                Answer::create([
                    'id_question' => $question->id,
                    'answer_text' => $row['answer' . $i],
                    'is_correct' => ($row['correct_answer'] == chr(64 + $i)),
                ]);
            }
        } else {
            return null; // Trả về null nếu tên tệp không chứa 'question_id'
        }

        $this->importSuccess = true;
    }

    public function importSuccess()
    {
        return $this->importSuccess;
    }
}
