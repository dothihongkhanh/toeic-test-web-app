<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_exam',
        'date',
        'total_time',
        'analysis',
    ];

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'id_user_exam');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'id_exam');
    }
}
