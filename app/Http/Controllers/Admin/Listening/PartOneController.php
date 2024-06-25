<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartOne\UpdatePartOneRequest;
use App\Http\Requests\PartOneRequest;
use App\Imports\PartOneImport;
use App\Models\Exam;
use App\Models\Image;
use App\Models\Part;
use App\Models\Question;
use App\Services\ExamService;
use App\Traits\NotificationUpdateQuestionTrait;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PartOneController extends Controller
{
    use NotificationUpdateQuestionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examsInPart1 = resolve(ExamService::class)->getExamsByPart(PartType::PartOne);

        return view('admin.listening.part-one.index', compact('examsInPart1'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.listening.part-one.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartOneRequest $request)
    {
        if ($request->validated()) {
            $file = $request->file('file_upload');
            $audioFiles = $request->file('audio_upload');
            $imageFiles = $request->file('image_upload');

            $import = new PartOneImport($audioFiles, $imageFiles);

            $result = Excel::import($import, $file);

            if ($result && $import->importSuccess()) {
                toastr()->success('Part 1 has been saved successfully!');
                return redirect()->route('list-part1');
            } else {
                toastr()->error('An error has occurred during import. Please try again later.');
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

        return view('admin.listening.part-one.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);

        return view('admin.listening.part-one.update', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartOneRequest $request, string $id)
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
                    $audioPath = $audioFile->store('listening/part1/audios', 'public');
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
                    $imagePath = $imageFile->store('listening/part1/images', 'public');
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
