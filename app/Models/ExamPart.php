<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_exam',
        'id_part',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'id_exam');
    }
}
