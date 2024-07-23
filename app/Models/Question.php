<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'url_audio',
        'transcript',
        'id_part',
    ];

    public function questionChilds()
    {
        return $this->hasMany(QuestionChild::class, 'id_question');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_question');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions', 'id_question', 'id_exam');
    }
}
