<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_image'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'image_questions', 'id_image', 'id_question');
    }
}
