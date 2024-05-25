<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartThree\CreatePartThreeRequest;
use App\Http\Requests\PartThree\UpdatePartThreeRequest;
use App\Imports\PartThreeImport;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Part;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartThreeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $part3 = Part::where('id', PartType::PartThree)->first();
        $examsInPart3 = $part3->exams()->get();


        return view('admin.listening.part-three.index', compact('examsInPart3'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-three.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePartThreeRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');
            $imageFiles = $request->file('image_upload');
            $import = new PartThreeImport($audioFiles, $imageFiles);
            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 3 has been saved successfully!');
                return redirect()->route('list-part3');
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

        return view('admin.listening.part-three.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.listening.part-three.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartThreeRequest $request, string $id)
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
                    $audioPath = $audioFile->store('listening/part3/audios', 'public');
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
                    $imagePath = $imageFile->store('listening/part3/images', 'public');
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
