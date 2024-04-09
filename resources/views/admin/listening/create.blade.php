@extends('admin.layouts.app')
@section('title', 'Upload Listening')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <a href="/admin/listening/list">
            <i class="fas fa-fw fa-arrow-left"></i>
            List Listening
        </a>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Part<span class="text-danger">*</span></label>
                <select class="form-control" name="id_part">
                    @foreach($listeningParts as $listeningPart)
                    <option value="{{ $listeningPart->id }}">{{ $listeningPart->name_part }}</option>
                    @endforeach
                </select>
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
            <div class="form-group">
                <label>Audios<span class="text-danger">*</span></label>
                <input type="file" id="audioUpload" accept="audio/*" name="audio_upload[]" class="form-control" multiple>
                @error('audio_upload')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Images</label>
                <input type="file" id="imageUpload" accept="image/*" name="image_upload[]" class="form-control" multiple>

                @error('image_upload')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
            <div style="border-top: 1px solid rgba(0, 0, 0);">
                <button type="submit" class="btn btn-primary mt-3">Save new</button>
            </div>
        </form>
    </div>

</div>
<script src="/js/upload-listening.js"></script>
@endsection