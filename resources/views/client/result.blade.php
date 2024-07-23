@extends('client.layouts.app')
@section('title', 'Kết quả thi - '.$exam->name_exam)
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary">Kết quả</p>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-lg-3 ">
                        <p class="text-black">Thời gian hoàn thành</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-primary">Số câu đúng</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-danger">Số câu sai</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-warning">Số câu bỏ qua</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 ">
                        <p class="text-black">{{ $userExam->total_time }}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-primary">{{ $totalCorrect }}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-danger">{{ $totalWrong }}</p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-warning">{{ $totalSkipped }}</p>
                    </div>
                </div>
                <a href="{{  route('client.analytics', ['id' => $userExam->id]) }}" class="btn btn-outline-primary mr-3">Xem phân tích kết quả</a>
                @switch($partOfExam)
                @case(App\Enums\PartType::PartOne)
                <a href="{{ route('part1.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartTwo)
                <a href="{{ route('part2.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartThree)
                <a href="{{ route('part3.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartFour)
                <a href="{{ route('part4.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartFive)
                <a href="{{ route('part5.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartSix)
                <a href="{{ route('part6.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @case(App\Enums\PartType::PartSeven)
                <a href="{{ route('part7.result.detail', ['id' => $userExam->id]) }}">Xem chi tiết đáp án</a>
                @break
                @default
                <p>Part không xác định</p>
                @endswitch
            </div>
        </div>
    </div>
</div>
@endsection