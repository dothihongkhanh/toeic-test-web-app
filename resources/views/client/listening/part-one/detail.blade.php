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
                                        <div class="col-lg-12 mb-2">
                                            <audio class="w-100" controls>
                                                <source src="{{ $question->url_audio }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @foreach($question->images as $image)
                                            <img src="{{ $image->url_image }}" alt="Question Image" class="img-fluid">
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
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
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <span>Thời gian làm bài:</span>
                            <input type="hidden" name="timeElapsed" id="timeElapsed" value="">
                            <div id="timer">00:00</div>
                            <div class="row row-cols-3 g-4">
                                @foreach ($questions as $question)
                                @foreach($question->questionChilds as $child)
                                <div class="col">
                                    <div class="p-3 border test-nav-item" data-question-id="{{ $child->id }}">
                                        {{ $child->question_number }}
                                    </div>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Submit</button>
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
        border-style: solid;
        border-color: red;
        font-weight: bold;
        color: #51be78;
    }
</style>