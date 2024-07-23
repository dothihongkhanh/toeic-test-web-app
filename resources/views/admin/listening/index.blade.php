@extends('admin.layouts.app')
@section('title', 'Listening')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Danh sách Part của Listening</h6>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($listeningParts as $listeningPart)
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="/admin/listening/list-part{{ $listeningPart->id }}" class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $listeningPart->name_part }}
                                    </a>
                                    <div class="text-xs mb-0 font-weight-bold text-gray-800">{{ $listeningPart->desc }}</div>
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