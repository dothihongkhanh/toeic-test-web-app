@extends('client.layouts.app')
@section('title', config('app.name'). ' - Part 7')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <a href="{{ route('client.listening.list') }}">
                    <i class="fas fa-solid fa-angle-left mr-2"></i>
                </a>
                <p class="m-0 font-weight-bold text-primary">PART 7</p>
            </div>
            @if (!$examsInPart7->isEmpty())
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examsInPart7 as $exam)
                            <tr>
                                <td>{{ $exam->id }}</td>
                                <td>{{ $exam->name_exam }}</td>
                                <td>{{ $exam->price }}</td>
                                <td>
                                    <a href="/practice-reading/part7/detail/{{ $exam->id }}" class="btn btn-primary">Test now</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="m-4 text-center">
                <h4>Không có dữ liệu!</h4>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection