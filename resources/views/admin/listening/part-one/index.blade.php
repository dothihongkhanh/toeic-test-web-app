@extends('admin.layouts.app')
@section('title', 'Listening - Part1')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách bài tập Part 1</h6>
        <a href="/admin/listening/create-part1" class="btn btn-primary">
            <i class="fas fa-upload fa-sm text-white-50"></i>
            <span>Tải lên file Part 1</span>
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
                    @foreach ($examsInPart1 as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->name_exam }}</td>
                        <td>{{ $exam->price }}</td>
                        <td>
                            <a href="/admin/listening/detail-part1/{{ $exam->id }}" class="btn btn-warning">Chi tiết</a>
                            @if (is_null($exam->deleted_at))
                            <form id="delete-form-{{ $exam->id }}" action="/admin/listening/delete/{{ $exam->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete btn-secondary" onclick="confirmDelete({{ $exam->id }})">Ẩn</button>
                            </form>
                            @else
                            <form id="restore-form-{{ $exam->id }}" action="/admin/listening/restore/{{ $exam->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="btn btn-restore btn-secondary" onclick="confirmRestore({{ $exam->id }})">Mở</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script>
    function confirmDelete(id) {
        if (confirm('Bạn chắc chắn muốn ẩn bài tập này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    function confirmRestore(id) {
        if (confirm('Bạn chắc chắn muốn hiển thị bài tập này?')) {
            document.getElementById('restore-form-' + id).submit();
        }
    }
</script>