@extends('admin.layouts.app')
@section('title', 'Reading')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách Part của Reading</h6>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($readingParts as $readingPart)
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="/admin/reading/list-part{{ $readingPart->id }}" class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $readingPart->name_part }}
                                    </a>
                                    <div class="text-xs mb-0 font-weight-bold text-gray-800">{{ $readingPart->desc }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection