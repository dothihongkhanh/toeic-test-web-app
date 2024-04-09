@extends('admin.layouts.app')
@section('title', 'Upload Listening')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <a href="/admin/listening/list">
            <i class="fas fa-fw fa-arrow-left"></i>
            List Listening question
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <p>Title</p>
            </div>
            <div class="col-md-8">
                <p>{{ $question->id }}</p>
                <p>{{ $question->question_title }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Answers</p>
            </div>
            <div class="col-md-8">
                @foreach($answers as $answer)
                <p>{{ $answer->answer_text }}</p>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Image URL</p>
            </div>
            <div class="col-md-8">
                @if($question->images)
                <img src="{{ $question->images->url_image }} ">
                @else
                <p>No image associated with this question</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Audio URL</p>
            </div>
            <div class="col-md-8">
                @if($question->images)
                <audio controls>
                    <source src="{{ $question->audios->url_audio }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                @else
                <p>No image associated with this question</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p>Answers correct</p>
            </div>
            <div class="col-md-8">
                @foreach($answers as $answer)
                @if($answer->is_correct == 1)
                <p>{{ $answer->answer_text }}</p>
                @endif
                @endforeach
            </div>
        </div>


    </div>

</div>
@endsection