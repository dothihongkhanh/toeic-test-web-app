@extends('client.layouts.app')
@section('title', 'Lịch sử thi - '.$exam->name_exam)
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary"><a href="{{ url()->previous() }}" class="d-inline">
                        <i class="fas fa-solid fa-angle-left"></i>
                    </a>{{ $exam->name_exam }}</p>
            </div>
            @if (!$userExams->isEmpty())
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <ul class="timeline">
                            @foreach($resultsArray as $result)
                            <li>
                                <span class="text-black font-weight-bold">{{ $result['date'] }}</span>
                                <br>
                                Số câu đúng: <span class="text-primary font-weight-bold">{{ $result['totalCorrect'] }}/{{ $result['totalChildQuestions'] }}</span>
                                <br>
                                Thời gian hoàn thành: {{ $result['total_time'] }}<br>
                                <a href="{{ route('part1.result.detail', ['id' => $result['idUserExam']]) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @else
            <div class="m-4 text-center">
                <h4>Bạn chưa thực hiện bài thi!</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
<style>
    ul.timeline {
        list-style-type: none;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: black;
        display: inline-block;
        position: absolute;
        left: 28px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 20px 0;
        padding-left: 20px;
    }

    ul.timeline>li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #51be78;
        left: 20px;
        width: 15px;
        height: 15px;
        z-index: 400;
    }
</style>