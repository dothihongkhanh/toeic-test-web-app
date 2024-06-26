<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_level'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'id_level');
    }
}
