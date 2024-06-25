<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_exam',
        'price',
        'time',
        'id_part',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'id_exam', 'id_question');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_exams', 'id_exam', 'id_user');
    }

    public function isPaidByUser($userId)
    {
        return $this->payments()->where('id_user', $userId)->exists();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_exam');
    }
}
