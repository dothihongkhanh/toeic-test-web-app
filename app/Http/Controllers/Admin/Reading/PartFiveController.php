<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartFive\CreatePartFiveRequest;
use App\Http\Requests\PartFive\UpdatePartFiveRequest;
use App\Imports\PartFiveImport;
use App\Models\Exam;
use App\Models\Part;
use App\Models\Question;
use App\Services\ExamService;
use App\Traits\NotificationUpdateQuestionTrait;
use Maatwebsite\Excel\Facades\Excel;

class PartFiveController extends Controller
{
    use NotificationUpdateQuestionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart5 = resolve(ExamService::class)->getExamsByPart(PartType::PartFive);

        return view('admin.reading.part-five.index', compact('examsInPart5'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reading.part-five.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartFiveRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $import = new PartFiveImport();
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 5 đã được lưu thành công!');
                return redirect()->route('list-part5');
            } else {
                toastr()->error('Đã xảy ra lỗi trong quá trình nhập. Vui lòng chọn đúng tập tin.');
                return redirect()->back();
            }
        } else {
            toastr()->error('Đã xảy ra lỗi, vui lòng thử lại sau.');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::findOrFail($id);
        $questions = $exam->questions()->get();

        return view('admin.reading.part-five.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.reading.part-five.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartFiveRequest $request, string $id)
    {
        $question = Question::findOrFail($id);

        foreach ($question->questionChilds as $child) {
            $childId = $child->id;
            $child->question_title = $request->input("question_title.$childId");
            $child->explanation = $request->input("explanation.$childId");
            $child->save();

            foreach ($child->answers as $answer) {
                $answerId = $answer->id;
                if (isset($request->answers[$answerId])) {
                    $answer->answer_text = $request->input("answers.$answerId");
                    $answer->is_correct = $request->input("correct_answer.$childId") == $answerId;
                    $answer->save();
                }
            }
        }
        $this->notifyUsersAboutUpdatedQuestion($question, $child);
        toastr()->success('Cập nhật thành công!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
