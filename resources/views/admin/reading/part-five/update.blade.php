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
                <div class="col-md-2">
                    <p>Tiêu đề câu hỏi<span class="text-danger">*</span></p>
                </div>
                <div class="col-md-8">
                    <input type="text" name="question_title[{{ $child->id }}]" class="form-control" placeholder="Enter question title" value="{{ old('question_title.' . $child->id, $child->question_title) }}">
                    @error('question_title.' . $child->id)
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
                    <textarea name="explanation[{{ $child->id }}]" class="form-control">{{ old('explanation.' . $child->id, $child->explanation) }}</textarea>
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