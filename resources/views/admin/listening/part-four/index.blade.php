@extends('admin.layouts.app')
@section('title', 'Listening - Part4')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách bài tập Part 4</h6>
        <a href="/admin/listening/create-part4" class="btn btn-primary">
            <i class="fas fa-upload fa-sm text-white-50"></i>
            <span>Tải lên file Part 4</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($examsInPart4 as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name_exam }}</td>
                        <td>{{ $exam->price }}</td>
                        <td>
                            <a href="/admin/listening/detail-part4/{{ $exam->id }}" class="btn btn-warning">Chi tiết</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection