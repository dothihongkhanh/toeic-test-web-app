@extends('client.layouts.app')
@section('title', config('app.name'). ' - Listening')
@section('content')
<div class="site-section bg-primary ">
    <div class="container">
        <div class="m-4 text-center">
            <h3 class="text-white">Luyện Listening</h3>
        </div>
        <div class="row">
            @foreach($listeningParts as $listeningPart)
            <div class="col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="/practice-listening/part{{ $listeningPart->id }}" class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $listeningPart->name_part }}
                                </a>
                                <div class="text-xs mb-0 font-weight-bold">{{ $listeningPart->desc }}</div>
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