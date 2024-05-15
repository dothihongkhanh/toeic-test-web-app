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
        return $this->hasMany(Question::class, 'id_exam');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_exams', 'id_exam', 'id_user');
    }
}
