<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionChild extends Model
{
    use HasFactory;    

    protected $table = 'question_child';

    protected $fillable = [
        'id_question',
        'question_number',
        'question_title',
        'explanation',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question_child');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }
}
