<?php

namespace App\Services;

use App\Models\UserExam;
use Illuminate\Support\Facades\DB;

class ExamStatisticService
{
    public function getExamResults($userID = null, $filterMonth = null)
    {
        $query = UserExam::query();

        if ($userID !== null) {
            $query->where('id_user', $userID);
        }

        if ($filterMonth !== 'all' && $filterMonth !== null) {
            // Extract year and month from $filterMonth (assuming format YYYY-MM)
            $filterYear = substr($filterMonth, 0, 4);
            $filterMonthNumber = substr($filterMonth, 5);

            $query->whereMonth('created_at', $filterMonthNumber);
            $query->whereYear('created_at', $filterYear);
        }

        // Nếu $filterMonth là "all" hoặc null, không thực hiện lọc dữ liệu
        $examResults = $query->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $formattedData = $examResults->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        })->toArray();

        return $formattedData;
    }
}
