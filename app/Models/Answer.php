<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_question_child',
        'answer_text',
        'is_correct'
    ];

    public function questionChild()
    {
        return $this->belongsTo(QuestionChild::class, 'id_question_child');
    }
}
