@extends('admin.layouts.app')
@section('title', 'Create Part5')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <a href="/admin/reading/list-part5">
            <i class="fas fa-fw fa-arrow-left"></i>
            List Question Part5
        </a>
    </div>
    <div class="card-body">
        <h4 class="mb-4 font-weight-bold text-primary">Upload Part5 Practice</h4>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Name practice<span class="text-danger">*</span></label>
                <input type="text" name="name_practice" class="form-control" placeholder="Enter practice name..." value="{{ old('name_practice') }}">
                @error('name_practice')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Price<span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="Enter price..." value="{{ old('price') }}">
                @error('price')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Type<span class="text-danger">*</span></label>
                <input type="text" name="type" class="form-control" value="{{ $nameType }}" disabled>
            </div>
            <div class="form-group">
                <label>Level<span class="text-danger">*</span></label>
                <select class="form-control" name="id_level">
                    @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name_level }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Content questions<span class="text-danger">*</span></label>
                <input type="file" accept=".xls,.xlsx" name="file_upload" class="form-control">
                @error('file_upload')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div style="border-top: 1px solid rgba(0, 0, 0);">
                <button type="submit" class="btn btn-primary mt-3">Save new</button>
            </div>
        </form>
    </div>
</div>
@endsection