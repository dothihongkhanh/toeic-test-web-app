<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_question',
        'url_image',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question');
    }
}
