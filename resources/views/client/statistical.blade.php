@extends('client.layouts.app')
@section('title', 'Thống kê kết quả luyện tập')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary">Thống kê chung</p>
            </div>
            <div class="card-body text-center">
                <p class="mt-4 font-weight-bold">Số bài tập đã làm: <b class="text-primary">{{ $countUserExams }}</b></p>
                <p class="mt-4 font-weight-bold">Tổng số thời gian luyện tập: <b class="text-primary">{{ $totalTime }}</b> phút</p>
                <p class="mt-4 font-weight-bold">Danh sách bài luyện tập đã làm:</p>
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
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê số lần luyện tập</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="examsChart" width="400" height="200"></canvas>

                            <div id="examsData" data-exams-data="{{ json_encode($examResultsCurrentUser) }}"></div>

                            <script>
                                var examsDataElement = document.getElementById('examsData');
                                var examsData = JSON.parse(examsDataElement.getAttribute('data-exams-data'));

                                var ctx = document.getElementById('examsChart').getContext('2d');

                                var dates = [];
                                var counts = [];

                                examsData.forEach(function(data) {
                                    dates.push(data.date);
                                    counts.push(data.count);
                                });

                                var examsChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: dates,
                                        datasets: [{
                                            label: 'Số lần luyện tập',
                                            data: counts,
                                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    callback: function(value, index, values) {
                                                        if (Number.isInteger(value) && value >= 0) {
                                                            return value;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Phân tích kết quả luyện tập</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area mx-auto mt-4">
                            <canvas id="myChart"></canvas>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const correctPercentage = parseFloat('{{ $correctPercentage }}');
                                    const wrongPercentage = parseFloat('{{ $wrongPercentage }}');
                                    const skippedPercentage = parseFloat('{{ $skippedPercentage }}');

                                    const ctx = document.getElementById('myChart').getContext('2d');
                                    const myChart = new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: ['Correct', 'Wrong', 'Skipped'],
                                            datasets: [{
                                                label: 'My Answers',
                                                data: [correctPercentage, wrongPercentage, skippedPercentage],
                                                backgroundColor: ['#51be78', '#f23a2e', '#C0C0C0'],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top'
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Phân tích kết quả luyện tập'
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>