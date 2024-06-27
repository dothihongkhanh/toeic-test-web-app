@extends('client.layouts.app')
@section('title', 'Đáp án chi tiết - '.$exam->name_exam)
@section('content')
<div class="site-section bg-primary">
    <div class="container mb-4">
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
                                            @if ($userAnswers->contains('id_user_answer', $answer->id))
                                            @if ($answer->is_correct)
                                            <b class="text-primary">{{ $answer->answer_text }} - Đúng</b>
                                            @else
                                            <b class="text-danger">{{ $answer->answer_text }} - Sai</b>
                                            @endif
                                            @else
                                            {{ $answer->answer_text }}
                                            @endif
                                        </p>
                                        @endforeach


                                        @foreach($child->answers as $answer)
                                        @if($answer->is_correct)
                                        <p>Đáp án đúng: <b class="text-primary">{{ $answer->answer_text }}</b></p>
                                        @endif
                                        @endforeach

                                        <h6 class="text-primary">Transcript:</h6>
                                        <p style="white-space: pre-line;">{{ $question->transcript }}</p>
                                        <h6 class="text-primary">Giải thích chi tiết đáp án:</h6>
                                        <p style="white-space: pre-line;">{{ $child->explanation }}</p>
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
                        <p class="text-primary">Part 1</p>
                        <div class="row">
                        @foreach ($questions as $question)
                            @foreach($question->questionChilds as $child)
                            <?php
                            $bgClass = '';
                            foreach ($child->answers as $answer) {
                                if ($userAnswers->contains('id_user_answer', $answer->id)) {
                                    if ($answer->is_correct) {
                                        $bgClass = 'bg-primary text-white';
                                    } else {
                                        $bgClass = 'bg-danger text-white';
                                    }
                                    break;
                                }
                            }
                            ?>
                            <div class="col-lg-4 mb-1">
                                <div class="test-nav-item border d-flex justify-content-center align-items-center p-1 {{ $bgClass }}" data-question-id="{{ $child->id }}">
                                    {{ $child->question_number }}
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection