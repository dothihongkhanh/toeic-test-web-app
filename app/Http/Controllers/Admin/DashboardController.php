<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\UserExam;
use App\Services\ExamStatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $countUser = User::where('id_role', UserRole::Client)->count();
        $countExam = Exam::count();
        $recordCount = UserExam::count();

        $userExams = UserExam::all();
        $monthYears = [];
        foreach ($userExams as $userExam) {
            $monthYear = \Carbon\Carbon::parse($userExam->created_at)->format('Y-m');

            if (!in_array($monthYear, $monthYears)) {
                $monthYears[] = $monthYear;
            }
        }

        $filterMonth = $request->input('selectedMonthYear');
        $examResultsAllUsers = resolve(ExamStatisticService::class)->getExamResults(null, $filterMonth);

        return view('admin.dashboard.index', compact('countUser', 'countExam', 'examResultsAllUsers', 'recordCount', 'monthYears'));
    }
}
