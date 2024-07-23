<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Part;

class ExamService
{
    public function getExamsByPart($partId)
    {
        $exams = Exam::select('exams.*')
            ->join('exam_questions', 'exams.id', '=', 'exam_questions.id_exam')
            ->join('questions', 'exam_questions.id_question', '=', 'questions.id')
            ->join('parts', 'questions.id_part', '=', 'parts.id')
            ->where('parts.id', $partId)
            ->distinct()->withTrashed()->get();;

        return $exams;
    }

    public function getPartByExam($examId)
    {
        $part = Exam::select('parts.id')
            ->join('exam_questions', 'exams.id', '=', 'exam_questions.id_exam')
            ->join('questions', 'exam_questions.id_question', '=', 'questions.id')
            ->join('parts', 'questions.id_part', '=', 'parts.id')
            ->where('exams.id', $examId)
            ->distinct()
            ->get();

        return $part;
    }
}
