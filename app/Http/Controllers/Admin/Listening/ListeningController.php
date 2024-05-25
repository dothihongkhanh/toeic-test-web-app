<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Enums\PartType;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Part;
use App\Models\Question;
use Illuminate\Http\Request;

class ListeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listeningParts = Part::where('id', 'like', PartType::PartOne)
            ->orWhere('id', 'like', PartType::PartTwo)
            ->orWhere('id', 'like', PartType::PartThree)
            ->orWhere('id', 'like', PartType::PartFour)
            ->get();

        return view('admin.listening.index', compact('listeningParts'));
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

        return view('admin.listening.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);
        return view('admin.listening.edit', compact('question'));
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
        //
    }
}
