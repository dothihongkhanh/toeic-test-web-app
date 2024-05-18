@extends('client.layouts.app')
@section('title', config('app.name'). ' - '.$exam->name_exam)
@section('content')
<div class="site-section bg-primary">
    <div class="container mb-4">
        <form id="testForm" action="{{ route('submit') }}" method="POST">
            @csrf
            <input type="hidden" name="idExam" value="{{ $exam->id }}">
            <div class="row">
                <div class="col-lg-9">
                    @foreach($questions as $question)
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($question->questionChilds as $child)
                            <div id="{{ $child->id }}" class="card shadow mb-4 ">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{ $child->question_number }}. {{ $child->question_title }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach($child->answers as $answer)
                                            <p>
                                                <input name="answer[{{ $child->id }}]" type="radio" class="mr-2" value="{{ $answer->id }}" />
                                                {{ $answer->answer_text }}
                                            </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-3">
                    <div class="card shadow mb-4 test-nav" style="position: sticky; top: 90px; max-width: 100%;">
                        <div class="card-body">
                            <span class="text-primary">Part 5</span>
                            <br>
                            <b>Thời gian làm bài:</b>
                            <input type="hidden" name="timeElapsed" id="timeElapsed" value="">
                            <div id="timer" class="text-black">00:00</div>
                            <div class="row">
                                @foreach ($questions as $question)
                                @foreach($question->questionChilds as $child)
                                <div class="col-lg-4 mb-2">
                                    <div class="test-nav-item border d-flex justify-content-center align-items-center p-1" data-question-id="{{ $child->id }}">
                                        {{ $child->question_number }}
                                    </div>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                            <button class="btn btn-primary w-100 mt-3" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
<style>
    .selected-answer {
        background-color: #33CCFF;
        font-weight: bold;
        color: #000;
    }
</style>
<script>
    window.onbeforeunload = function() {
        return "Changes you made may not be saved.";
    }
</script>