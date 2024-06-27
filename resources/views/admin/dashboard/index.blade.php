@extends('admin.layouts.app')
@section('title', 'Thống kê')
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Người dùng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countUser }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Bài luyện tập</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countExam }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng số lượt luyện tập</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $recordCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Bài tập có lượt luyện tập nhiều nhất</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Số lượt luyện tập</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($popularExams as $popularExam)
                            <tr>
                                <td>{{ $popularExam->name_exam }}</td>
                                <td>{{ $popularExam->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-7">
        <form action="{{ route('admin') }}" method="GET">
            <p>Chọn thời gian</p>
            <div class="d-flex align-items-center">
                <select class="form-control" name="selectedMonthYear" id="selectedMonthYear">
                    <option value="all">Tất cả</option>
                    @foreach ($monthYears as $monthYear)
                    <option value="{{ $monthYear }}">{{ $monthYear }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-block ml-2" style="width: 15%;">Thống Kê</button>
            </div>

        </form>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Thống kê số lượt luyện tập</h6>
            </div>
            <div class="card-body">
                <div class="chart-area m-auto">
                    <canvas id="examsChart" width="100" height="40"></canvas>

                    <div id="examsData" data-exams-data="{{ json_encode($examResultsAllUsers) }}"></div>

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
                                    label: 'Số lượt luyện tập',
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
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>