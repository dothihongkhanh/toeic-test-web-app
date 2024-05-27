<?php

namespace App\Http\Controllers\Admin\Reading;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartSix\CreatePartSixRequest;
use App\Http\Requests\PartSix\UpdatePartSixRequest;
use App\Imports\PartSixImport;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Part;
use App\Models\Question;
use App\Traits\NotificationUpdateQuestionTrait;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartSixController extends Controller
{
    use NotificationUpdateQuestionTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $part6 = Part::where('id', PartType::PartSix)->first();
        $examsInPart6 = $part6->exams()->get();

        return view('admin.reading.part-six.index', compact('examsInPart6'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reading.part-six.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartSixRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $imageFiles = $request->file('image_upload');
            $import = new PartSixImport($imageFiles);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 6 has been saved successfully!');
                return redirect()->route('list-part6');
            } else {
                toastr()->error('An error has occurred during import. Please select the correct file.');
                return redirect()->back();
            }
        } else {
            toastr()->error('An error has occurred please try again later.');

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

        return view('admin.reading.part-six.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.reading.part-six.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartSixRequest $request, string $id)
    {
        $question = Question::findOrFail($id);
        $questionId = $question->id;
        $question->transcript = $request->input("transcript.$questionId");
        $question->save();

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            if (preg_match('/(\d+)_image_/', $imageName, $matches)) {
                $idQuestionFromimageName = $matches[1];
                if ($question->code == $idQuestionFromimageName) {
                    $imagePath = $imageFile->store('reading/part6/images', 'public');
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
