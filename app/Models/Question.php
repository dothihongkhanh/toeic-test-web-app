<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_part',
        'question_number',
        'question_title',
        'explanation',
        'id_audio',
        'id_trans',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part');
    }

    public function audio()
    {
        return $this->belongsTo(Audio::class, 'id_audio');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_questions', 'id_image', 'id_question');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions', 'id_exam', 'id_question');
    }

    public function transcript()
    {
        return $this->belongsTo(Transcript::class, 'id_trans');
    }
}
