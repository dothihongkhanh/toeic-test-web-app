<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\Question;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readingParts = Part::where('id', 'like', PartType::PartFive)
            ->orWhere('id', 'like', PartType::PartSix)
            ->orWhere('id', 'like', PartType::PartSeven)
            ->get();

        return view('admin.reading.index', compact('readingParts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('admin.reading.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.reading.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Exam::findOrFail($id);
            $user->delete();

            toastr()->success('Ẩn bài tập thành công!');

            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Có lỗi khi ẩn bài tập!');

            return redirect()->back();
        }
    }

    public function restore(string $id)
    {
        try {
            $user = Exam::withTrashed()->findOrFail($id);
            $user->restore();

            toastr()->success('Hoàn tác ấn bài tập thành công!');

            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Có lỗi khi hoàn tác ẩn bài tập!');

            return redirect()->back();
        }
    }
}
