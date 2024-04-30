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
        'id_type',
        'id_level',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'id_exam', 'id_question');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }
}
