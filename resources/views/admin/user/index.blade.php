@extends('admin.layouts.app')
@section('title', 'Quản lý người dùng')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số bài đã luyện tập</th>
                        <th>Mở khóa/ Khóa tài khoản</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->numberOfExams() }}</td>
                        <td>
                            @if (is_null($user->deleted_at))
                            <form id="delete-form-{{ $user->id }}" action="/admin/users/delete/{{ $user->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete btn-danger" onclick="confirmDelete({{ $user->id }})">Khóa</button>
                            </form>
                            @else
                            <form id="restore-form-{{ $user->id }}" action="/admin/users/restore/{{ $user->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="btn btn-restore btn-success" onclick="confirmRestore({{ $user->id }})">Mở</button>
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
        if (confirm('Bạn chắc chắn muốn khóa tài khoản này?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    function confirmRestore(id) {
        if (confirm('Bạn chắc chắn muốn mở khóa tài khoản này?')) {
            document.getElementById('restore-form-' + id).submit();
        }
    }
</script>