@extends('client.layouts.app')
@section('title', 'Phân tích kết quả luyện tập')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary">Phân tích kết quả</p>
            </div>
            <div class="card-body text-center">
                <div style="white-space: pre-line; text-align: justify;">{!! $textAnalysis !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection