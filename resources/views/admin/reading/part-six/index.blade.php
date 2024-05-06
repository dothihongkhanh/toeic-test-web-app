@extends('admin.layouts.app')
@section('title', 'Reading - Part6')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">List Reading Question Part6</h6>
        <a href="/admin/reading/create-part6" class="btn btn-primary">
            <i class="fas fa-upload fa-sm text-white-50"></i>
            <span>Upload file reading</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams_in_part6 as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name_exam }}</td>
                        <td>{{ $exam->price }}</td>
                        <td>{{ $exam->name_level}}</td>
                        <td>
                            <a href="/admin/reading/detail/{{ $exam->id }}" class="btn btn-warning">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection