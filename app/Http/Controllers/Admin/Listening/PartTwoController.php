<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartTwo\UpdatePartTwoRequest;
use App\Http\Requests\PartTwoRequest;
use App\Imports\PartTwoImport;
use App\Models\Exam;
use App\Models\Question;
use App\Services\ExamService;
use App\Traits\NotificationUpdateQuestionTrait;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartTwoController extends Controller
{
    use NotificationUpdateQuestionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart2 = resolve(ExamService::class)->getExamsByPart(PartType::PartTwo);

        return view('admin.listening.part-two.index', compact('examsInPart2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-two.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartTwoRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');

            $import = new PartTwoImport($audioFiles);

            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 2 đã được lưu thành công!');
                return redirect()->route('list-part2');
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

        return view('admin.listening.part-two.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.listening.part-two.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartTwoRequest $request, string $id)
    {
        $question = Question::findOrFail($id);
        $questionId = $question->id;
        $question->transcript = $request->input("transcript.$questionId");
        $question->save();

        if ($request->hasFile('audio')) {
            $audioFile = $request->file('audio');
            $audioName = $audioFile->getClientOriginalName();
            if (preg_match('/(\d+)_audio_/', $audioName, $matches)) {
                $idQuestionFromAudioName = $matches[1];
                if ($question->code == $idQuestionFromAudioName) {
                    $audioPath = $audioFile->store('listening/part2/audios', 'public');
                    $question->url_audio = Storage::url($audioPath);
                } else {
                    toastr()->error('Nội dung audio không khớp với câu hỏi');
                    return redirect()->back();
                }
            } else {
                toastr()->error('Tên audio không đúng định dạng');
                return redirect()->back();
            }
        }

        foreach ($question->questionChilds as $child) {
            $childId = $child->id;
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
