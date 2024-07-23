@extends('admin.layouts.app')
@section('title', 'Cập nhật câu hỏi')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
    <b class="text-primary">Cập nhật câu hỏi</b>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($question->questionChilds as $child)
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Số thứ tự<span class="text-danger">*</span></p>
                </div>
                <div class="col-md-8">
                    <p>{{ $child->question_number }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2"><label for="audio">Âm thanh<span class="text-danger">*</span></label></div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="file" class="form-control" accept="audio/*" id="audio" name="audio" onchange="displayOldAudio()">
                        <audio controls id="oldAudio">
                            <source src="{{ $question->url_audio }}" type="audio/mpeg">
                            Trình duyệt của bạn không hỗ trợ các yếu tố âm thanh.
                        </audio>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Dịch nghĩa<span class="text-danger">*</span></p>
                </div>
                <div class="col-md-8">
                    <textarea name="transcript[{{ $question->id }}]" class="form-control" style="height: 150px;">{{ old('transcript.' . $question->id, $question->transcript) }}</textarea>
                    @error('transcript.' . $question->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Đáp án<span class="text-danger">*</span></p>
                </div>
                <div class="col-md-8">
                    @foreach($child->answers as $index => $answer)
                    <div class="form-check">
                        <input type="radio" name="correct_answer[{{ $child->id }}]" class="form-check-input" value="{{ $answer->id }}" {{ $answer->is_correct ? 'checked' : '' }}>
                        <label class="form-check-label">
                            <input type="text" name="answers[{{ $answer->id }}]" class="form-control mb-2" placeholder="Enter answer text" value="{{ old('answers.' . $answer->id, $answer->answer_text) }}">
                        </label>
                    </div>
                    @error('answers.' . $answer->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                    @endforeach
                    @error('correct_answer.' . $child->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Giải thích<span class="text-danger">*</span></p>
                </div>
                <div class="col-md-8">
                    <textarea name="explanation[{{ $child->id }}]" class="form-control" style="height: 150px;">{{ old('explanation.' . $child->id, $child->explanation) }}</textarea>
                    @error('explanation.' . $child->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary mb-4">Lưu thay đổi</button>
        </form>
    </div>
</div>
@endsection
<script>
    function displayOldAudio() {
        var audioInput = document.getElementById('audio');
        var oldAudio = document.getElementById('oldAudio');
        var files = audioInput.files;
        if (files.length > 0) {
            var file = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                oldAudio.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>