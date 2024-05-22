@extends('client.layouts.app')
@section('title', config('app.name'). ' - Part')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">Phần Listening</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Part</th>
                                <th>Mô tả</th>
                                <th>Số câu</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listeningParts as $listeningPart)
                            <tr>
                                <td>{{ $listeningPart->name_part }}</td>
                                <td>{{ $listeningPart->desc }}</td>
                                <td>{{ $listeningPart->number_question }}</td>
                                <td>
                                    <a href="/practice-listening/part{{ $listeningPart->id }}" class="btn btn-outline-primary">Vào thi {{ $listeningPart->name_part}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">Phần Reading</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Part</th>
                                <th>Mô tả</th>
                                <th>Số câu</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($readingParts as $readingPart)
                            <tr>
                                <td>{{ $readingPart->name_part }}</td>
                                <td>{{ $readingPart->desc }}</td>
                                <td>{{ $readingPart->number_question }}</td>
                                <td>
                                    <a href="/practice-reading/part{{ $readingPart->id }}" class="btn btn-outline-primary">Vào thi {{ $readingPart->name_part}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection