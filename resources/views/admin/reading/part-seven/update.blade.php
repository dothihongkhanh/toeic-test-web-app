@extends('admin.layouts.app')
@section('title', 'Update Question')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @foreach($question->images as $image)
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Image</p>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="file" class="form-control" accept="image/*" id="image{{ $loop->index }}" name="image[]" onchange="displayOldImage(this, 'oldImage{{ $loop->index }}')">
                        <img id="oldImage{{ $loop->index }}" src="{{ $image->url_image }}" alt="Question Image" style="width: 80%;">
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Transcript</p>
                </div>
                <div class="col-md-8">
                    <textarea name="transcript[{{ $question->id }}]" class="form-control" style="height: 300px;">{{ old('transcript.' . $question->id, $question->transcript) }}</textarea>
                    @error('transcript.' . $question->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            @foreach($question->questionChilds as $child)
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Question number</p>
                </div>
                <div class="col-md-8">
                    <p>{{ $child->question_number }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Question title</p>
                </div>
                <div class="col-md-8">
                    <input type="text" name="question_title[{{ $child->id }}]" class="form-control mb-2" placeholder="Enter question title" value="{{ old('question_title.' . $child->id, $child->question_title) }}">
                    @error('question_title.' . $child->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <p>Answers</p>
                </div>
                <div class="col-md-8">
                    @foreach($child->answers as $index => $answer)
                    <div class="form-check">
                        <input type="radio" name="correct_answer[{{ $child->id }}]" class="form-check-input" value="{{ $answer->id }}" {{ $answer->is_correct ? 'checked' : '' }}>
                        <input type="text" name="answers[{{ $answer->id }}]" class="form-control mb-2" placeholder="Enter answer text" value="{{ old('answers.' . $answer->id, $answer->answer_text) }}">
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
                    <p>Explanation</p>
                </div>
                <div class="col-md-8">
                    <textarea name="explanation[{{ $child->id }}]" class="form-control" style="height: 150px;">{{ old('explanation.' . $child->id, $child->explanation) }}</textarea>
                    @error('explanation.' . $child->id)
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary mb-4">Save changes</button>
        </form>
    </div>
</div>
@endsection
<script>
    function displayOldImage(input, imageId) {
        var files = input.files;
        if (files.length > 0) {
            var file = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var oldImage = document.getElementById(imageId);
                oldImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>