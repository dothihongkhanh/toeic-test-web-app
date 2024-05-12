<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'id_exam',
        'url_audio',
        'transcript',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'id_exam');
    }

    public function questionChilds()
    {
        return $this->hasMany(QuestionChild::class, 'id_question');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_question');
    }
}
