@extends('admin.layouts.app')
@section('title', 'Listening')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">List Listening Question</h6>
        <a href="/admin/listening/create" class="btn btn-primary">
            <i class="fas fa-upload fa-sm text-white-50"></i>
            <span>Upload file Listening</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Part</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question_title }}</td>
                        <td>{{ $question->part->name_part }}</td>
                        <td>{{ $question->level->name_level }}</td>
                        <td>
                            <a href="/admin/listening/detail/{{ $question->id }}" class="btn btn-warning">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ $questions->links() }}
@endsection