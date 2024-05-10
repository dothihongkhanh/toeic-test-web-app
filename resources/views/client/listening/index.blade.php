@extends('client.layouts.app')
@section('title', config('app.name'). ' - Listening')
@section('content')

<div class="site-section ftco-subscribe-1 pb-4" style="background-image: url('/template/client/images/bg_1.jpg')">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-7">
                <h2 class="mb-0">Listening</h2>
            </div>
        </div>
    </div>
</div>

<div class="custom-breadcrumns border-bottom">
    <div class="container">
        <a href="/">Home</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Listening</span>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            @foreach($listeningParts as $listeningPart)
            <div class="col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="/practice-listening/list-part{{ $listeningPart->id }}" class="h5 font-weight-bold text-primary text-uppercase mb-1">
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