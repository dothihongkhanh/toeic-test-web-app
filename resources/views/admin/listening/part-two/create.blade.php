@extends('admin.layouts.app')
@section('title', 'Thêm bài tập Part 2')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <a href="{{ route('list-part2') }}">
            <i class="fas fa-fw fa-arrow-left"></i>
            Danh sách bài tập Part 2
        </a>
    </div>
    <div class="card-body">
        <h4 class="mb-4 font-weight-bold text-primary">Thêm mới bài tập Part 2</h4>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Tên bài tập<span class="text-danger">*</span></label>
                <input type="text" name="name_practice" class="form-control" placeholder="Nhập tên bài tập" value="{{ old('name_practice') }}">
                @error('name_practice')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Giá<span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="Nhập giá" value="{{ old('price') }}">
                @error('price')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Nội dung câu hỏi (File excel - 25 câu hỏi)<span class="text-danger">*</span></label>
                <input type="file" accept=".xls,.xlsx" name="file_upload" class="form-control">
                @error('file_upload')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>File âm thanh (25 files)<span class="text-danger">*</span></label>
                <input type="file" id="audioUpload" accept="audio/*" name="audio_upload[]" class="form-control" multiple>
                @error('audio_upload')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div style="border-top: 1px solid rgba(0, 0, 0);">
                <button type="submit" class="btn btn-primary mt-3">Lưu mới</button>
            </div>
        </form>
    </div>

</div>
<script src="/js/upload-listening.js"></script>
@endsection