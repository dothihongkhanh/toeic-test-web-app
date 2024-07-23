<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user_exam',
        'id_user_answer',
    ];

    public function questionChild()
    {
        return $this->belongsTo(QuestionChild::class, 'id_question_child');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'id_user_answer');
    }

    public function userExam()
    {
        return $this->belongsTo(UserExam::class, 'id_user_exam');
    }
}
