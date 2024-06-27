@extends('admin.layouts.app')
@section('title', 'Update Part - ' . $part->name_part)
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="/admin/parts/list">
            <i class="fas fa-fw fa-arrow-left"></i>
            Danh sách Part
        </a>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên<span class="text-danger">*</span></label>
                <input type="text" name="name_part" class="form-control" placeholder="Nhập tên Part" value="{{ $part->name_part }}">
                @error('name_part')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Hướng dẫn<span class="text-danger">*</span></label>
                <textarea name="direction" class="form-control" placeholder="Nhập hướng dẫn">{{ $part->direction }}</textarea>
                @error('direction')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Mô tả<span class="text-danger">*</span></label>
                <textarea name="desc" class="form-control" placeholder="Nhập mô tả">{{ $part->desc }}</textarea>
                @error('desc')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Số câu hỏi<span class="text-danger">*</span></label>
                <input type="number" name="number_question" class="form-control" placeholder="Nhập số câu hỏi" value="{{ $part->number_question }}">
                @error('number_question')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div style="border-top: 1px solid rgba(0, 0, 0);">
                <button type="submit" class="btn btn-primary mt-3">Lưu cập nhật</button>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection