@extends('client.layouts.app')
@section('title', 'Thống kê kết quả luyện tập')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary">Thống kê kết quả</p>
            </div>
            <div class="card-body text-center">
                <p>Số bài tập đã làm: <b class="text-primary">{{ $countUserExams }}</b></p>
                <p>Tổng số thời gian luyện tập: <b class="text-primary">{{ $totalTime }}</b> phút</p>
                <p>Danh sách đề thi đã làm:</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Ngày làm</th>
                                <th>Bài tập</th>
                                <th>Kết quả</th>
                                <th>Thời gian làm bài</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userExams as $userExam)
                            <tr>
                                <td>{{ $userExam->created_at }}</td>
                                <td>{{ $userExam->exam->name_exam }}</td>
                                <td>{{ $userExam->totalCorrect }}/{{ $userExam->totalChildQuestions }}</td>
                                <td>{{ $userExam->total_time }}</td>
                                <td>
                                    <a href="{{ route('result', $userExam->id) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection