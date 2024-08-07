@extends('admin.layouts.app')
@section('title', 'Quản lý Part')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Part</h6>
        <a href="/admin/parts/create" class="btn btn-primary">
            <i class="fas fa-fw fa-plus"></i>
            <span>Thêm Part</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Hướng dẫn</th>
                        <th>Mô tả</th>
                        <th>Số câu hỏi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parts as $part)
                    <tr>
                        <td>{{ $part->id }}</td>
                        <td>{{ $part->name_part }}</td>
                        <td>{{ $part->direction }}</td>
                        <td>{{ $part->desc }}</td>
                        <td>{{ $part->number_question }}</td>
                        <td>
                            <a href="/admin/parts/update/{{ $part->id }}" class="btn btn-warning">Sửa</a>
                            <form id="delete-form-{{ $part->id }}" action="/admin/parts/delete/{{ $part->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete btn-danger" onclick="confirmDelete({{ $part->id }})">Xóa</button>
                            </form>
                            <script>
                                function confirmDelete(id) {
                                    if (confirm('Bạn có muốn xóa Part này?')) {
                                        document.getElementById('delete-form-' + id).submit();
                                    }
                                }
                            </script>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection