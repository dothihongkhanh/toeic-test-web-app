@extends('admin.layouts.app')
@section('title', 'Chi tiết - ' .$exam->name_exam)
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <a href="{{ route('admin.reading.list') }}">
            <i class="fas fa-fw fa-arrow-left"></i>
            List Listening question
        </a>
    </div>
    <h4 class="m-4 font-weight-bold text-primary">{{ $exam->name_exam }}</h4>
    @foreach($questions as $question)
    <div class="card-body">
        @if($question->images->isNotEmpty())
        @foreach($question->images as $image)
        <div class="row">
            <div class="col-md-2">
                <p>Image</p>
            </div>
            <div class="col-md-8">
                <img src="{{ $image->url_image }}" alt="Question Image" style="width: 80%;">
            </div>
        </div>
        @endforeach
        @endif
        @if($question->transcript)
        <div class="row">
            <div class="col-md-2">
                <p>Transcript</p>
            </div>
            <div class="col-md-8">
                <p style="white-space: pre-line;">{{ $question->transcript }}</p>
            </div>
        </div>
        @endif
        @foreach($question->questionChilds as $child)
        <div>
            <div class="row">
                <div class="col-md-2">
                    <p>Question number</p>
                </div>
                <div class="col-md-8">
                    <p>{{ $child->question_number }}</p>
                </div>
            </div>
            @if($child->question_title)
            <div class="row">
                <div class="col-md-2">
                    <p>Question title</p>
                </div>
                <div class="col-md-8">
                    <p>{{ $child->question_title }}</p>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-2">
                    <p>Answers</p>
                </div>
                <div class="col-md-8">
                    @foreach($child->answers as $answer)
                    <p>{{ $answer->answer_text }} - {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}</p>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>Answers correct</p>
                </div>
                <div class="col-md-8">
                    @foreach($child->answers as $answer)
                    @if($answer->is_correct)
                    <p>{{ $answer->answer_text }}</p>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p>Explanation</p>
                </div>
                <div class="col-md-8">
                    <p style="white-space: pre-line;">{{ $child->explanation }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <a href="/admin/reading/update/{{ $question->id }}" class="btn btn-warning mb-4">Edit</a>
    <div style="border-top: 1px solid rgba(0, 0, 0);"></div>
    @endforeach
</div>
@endsection