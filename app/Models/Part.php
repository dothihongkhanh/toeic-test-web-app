<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_part',
        'direction',
        'desc',
        'number_question'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'id_part');
    }
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_parts', 'id_part', 'id_exam');
    }
}
