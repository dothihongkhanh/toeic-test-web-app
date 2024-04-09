<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_part',
        'id_level',
        'question_title',
        'id_image',
        'id_audio'
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }

    public function audios()
    {
        return $this->belongsTo(Audio::class, 'id_audio');
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'id_question');
    }
}
