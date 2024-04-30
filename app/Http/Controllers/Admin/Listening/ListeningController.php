<?php

namespace App\Http\Controllers\Admin\Listening;

use App\Http\Controllers\Controller;
use App\Imports\ListeningQuestionsImport;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Part;
use App\Models\Question;
use App\Models\Type;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ListeningController extends Controller
{
    protected $part;

    public function __construct(Part $part)
    {
        $this->part = $part;
    }

    protected function getLevels() {
        return Level::get(['id', 'name_level']);
    }

    protected function getTypes() {
        return Type::get(['id', 'name_type']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $exams = Exam::paginate(5);
        // // $questions = Question::with('part')->oldest('id')->paginate(5);
        // return view('admin.listening.index', compact('exams'));

        $listeningParts = $this->part::where('name_part', 'like', 'Part %')
            ->whereRaw('CAST(SUBSTRING(name_part, 6) AS UNSIGNED) BETWEEN 1 AND 4')
            ->get();

        $levels = Level::get(['id', 'name_level']);
        return view('admin.listening.index', compact('listeningParts', 'levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listeningParts = $this->part::where('name_part', 'like', 'Part %')
            ->whereRaw('CAST(SUBSTRING(name_part, 6) AS UNSIGNED) BETWEEN 1 AND 4')
            ->get();

        $levels = Level::get(['id', 'name_level']);
        return view('admin.listening.create', compact('listeningParts', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $levelId = $request->input('id_level');
        $partId = $request->input('id_part');


        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');

            Excel::import(new ListeningQuestionsImport($levelId, $partId), $file);

            toastr()->success('Listening has been saved successfully!');
            return redirect()->route('admin.listening.list');
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
        $questions = $exam->questions()->with('answers')->get();
        return view('admin.listening.detail', compact('exam', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
