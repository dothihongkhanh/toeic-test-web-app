@extends('admin.layouts.app')
@section('title', 'Create Part')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="/admin/parts/list">
            <i class="fas fa-fw fa-arrow-left"></i>
            List part
        </a>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name<span class="text-danger">*</span></label>
                <input type="text" name="name_part" class="form-control" placeholder="Enter part name..." value="{{ old('name_part') }}">
                @error('name_part')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Direction<span class="text-danger">*</span></label>
                <textarea name="direction" class="form-control" placeholder="Enter direction...">{{ old('direction') }}</textarea>
                @error('direction')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Description<span class="text-danger">*</span></label>
                <textarea name="desc" class="form-control" placeholder="Enter description...">{{ old('desc') }}</textarea>
                @error('desc')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Number question<span class="text-danger">*</span></label>
                <input type="number" name="number_question" class="form-control" placeholder="Enter number question..." value="{{ old('number_question') }}">
                @error('number_question')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div style="border-top: 1px solid rgba(0, 0, 0);">
                <button type="submit" class="btn btn-primary mt-3">Save new</button>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection