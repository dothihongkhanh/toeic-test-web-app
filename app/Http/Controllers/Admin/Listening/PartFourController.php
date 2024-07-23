<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartFour\CreatePartFourRequest;
use App\Http\Requests\PartFour\UpdatePartFourRequest;
use App\Imports\PartFourImport;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Part;
use App\Models\Question;
use App\Services\ExamService;
use App\Traits\NotificationUpdateQuestionTrait;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartFourController extends Controller
{
    use NotificationUpdateQuestionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart4 = resolve(ExamService::class)->getExamsByPart(PartType::PartFour);

        return view('admin.listening.part-four.index', compact('examsInPart4'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-four.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartFourRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $rows = Excel::toArray([], $file);
            $rowCount = count($rows[0]);
            $audioFiles = $request->file('audio_upload');
            $imageFiles = $request->file('image_upload');
            // $import = new PartFourImport($audioFiles, $imageFiles);
            // $result = Excel::import($import, $file);

            if ($rowCount == 31) {
                $import = new PartFourImport($audioFiles, $imageFiles);
                $result = Excel::import($import, $file);

                if ($result && $import->importSuccess()) {
                    toastr()->success('Part 4 đã được lưu thành công!');
                    return redirect()->route('list-part4');
                } else {
                    toastr()->error('Đã xảy ra lỗi trong quá trình nhập. Vui lòng chọn đúng tập tin.');
                    return redirect()->back();
                }
            } else {
                toastr()->error('Tập tin phải chứa chính xác 30 câu hỏi. Vui lòng chọn đúng tập tin.');
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

        return view('admin.listening.part-four.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.listening.part-four.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartFourRequest $request, string $id)
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
                    $audioPath = $audioFile->store('listening/part4/audios', 'public');
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

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                $idQuestionFromimageName = $matches[1];
                if ($question->code == $idQuestionFromimageName) {
                    $imagePath = $imageFile->store('listening/part4/images', 'public');
                    $image = Image::where('id_question', $questionId)->first();
                    if ($image) {
                        $image->url_image = Storage::url($imagePath);
                        $image->save();
                    } else {
                        Image::create([
                            'url_image' => Storage::url($imagePath),
                            'id_question' => $questionId,
                        ]);
                    }
                } else {
                    toastr()->error('Nội dung hình ảnh không khớp với câu hỏi');
                    return redirect()->back();
                }
            } else {
                toastr()->error('Tên ảnh không đúng định dạng');
                return redirect()->back();
            }
        }

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
