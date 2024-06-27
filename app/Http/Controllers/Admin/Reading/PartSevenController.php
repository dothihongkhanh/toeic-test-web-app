<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartSeven\CreatePartSevenRequest;
use App\Http\Requests\PartSeven\UpdatePartSevenRequest;
use App\Imports\PartSevenImport;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Part;
use App\Models\Question;
use App\Services\ExamService;
use App\Traits\NotificationUpdateQuestionTrait;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartSevenController extends Controller
{
    use NotificationUpdateQuestionTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart7 = resolve(ExamService::class)->getExamsByPart(PartType::PartSeven);
        
        return view('admin.reading.part-seven.index', compact('examsInPart7'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reading.part-seven.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartSevenRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $imageFiles = $request->file('image_upload');
            $import = new PartSevenImport($imageFiles);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 7 đã được lưu thành công!');
                return redirect()->route('list-part7');
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

        return view('admin.reading.part-seven.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.reading.part-seven.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartSevenRequest $request, string $id)
    {
        $question = Question::findOrFail($id);
        $questionId = $question->id;
        $question->transcript = $request->input("transcript.$questionId");
        $question->save();

        if ($request->hasFile('image')) {
            $imageFiles = $request->file('image');
            foreach ($imageFiles as $imageFile) {
                $imageName = $imageFile->getClientOriginalName();
                if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                    $idQuestionFromimageName = $matches[1];
                    if ($question->code == $idQuestionFromimageName) {
                        $imagePath = $imageFile->store('reading/part7/images', 'public');
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
