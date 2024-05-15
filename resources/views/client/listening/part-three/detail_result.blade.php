@extends('client.layouts.app')
@section('title', 'Đáp án chi tiết - '.$exam->name_exam)
@section('content')
<div class="site-section bg-primary">
    <div class="container mb-4">
        <div class="row">
            <div class="col-lg-9">
                @foreach($questions as $question)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4 ">
                            <div class="card-header py-3">
                                <audio class="w-100" controls>
                                    <source src="{{ $question->url_audio }}" type="audio/mpeg">
                                </audio>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            @foreach($question->questionChilds as $child)
                                            <div id="{{ $child->id }}" class="col-md-12">
                                                <h6 class="m-0 font-weight-bold text-primary">{{ $child->question_number }}. {{ $child->question_title }}</h6>
                                                @foreach($child->answers as $answer)
                                                <p>
                                                    @if ($userAnswers->contains('id_user_answer', $answer->id))
                                                    @if ($answer->is_correct)
                                                    <b class="text-primary">{{ $answer->answer_text }} - Correct</b>
                                                    @else
                                                    <b class="text-danger">{{ $answer->answer_text }} - Incorrect</b>
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

                                                <h6 class="text-primary">Giải thích chi tiết đáp án:</h6>
                                                <p style="white-space: pre-line;">{{ $child->explanation }}</p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @foreach($question->images as $image)
                                        <img src="{{ $image->url_image }}" alt="Question Image" class="img-fluid">
                                        @endforeach

                                        <h6 class="text-primary">Transcript:</h6>
                                        <p style="white-space: pre-line;">{{ $question->transcript }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-3">
                <div class="card shadow mb-4 test-nav" style="position: sticky; top: 90px; max-width: 100%;">
                    <div class="card-body">
                        <p class="text-primary">Part 3</p>
                        <div class="row d-flex justify-content-center align-items-center">
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
                            <div class="mb-2">
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