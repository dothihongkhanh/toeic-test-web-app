<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_exam',
        'id_question',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'id_exam');
    }
}
