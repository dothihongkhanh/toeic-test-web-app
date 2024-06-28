@extends('client.layouts.app')
@section('title', config('app.name'). ' - Part 1')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <a href="{{ route('client.listening.list') }}" class="d-inline">
                    <i class="fas fa-solid fa-angle-left mr-2"></i>
                </a>
                <p class="m-0 font-weight-bold text-primary d-inline">PART 1</p>
            </div>
            @if (!$examsInPart1->isEmpty())
            <div class="card-body">
                @foreach ($examsInPart1 as $exam)
                @if($exam->deleted_at === null)
                <div class="card shadow mb-4">
                    <div class="card-body d-flex align-items-center">
                        <div>
                            <span class="font-weight-bold text-black">{{ $exam->name_exam }}</span>
                            @if ($exam->users()->where('id_user', auth()->id())->exists())
                            <span class="text-primary font-italic">(Hoàn thành)</span>
                            @else
                            <span class="text-danger font-italic">(Chưa làm)</span>
                            @endif
                            <br>
                            @if($exam->isPaidByUser(auth()->id()))
                            <div class="text-primary d-inline-block pl-1 pr-1" style="border: 1px solid #51be78; border-radius: 5px">{{ number_format($exam->price, 0, ',', '.') }} VND</div>
                            @elseif($exam->price > 0)
                            <div class="text-danger d-inline-block pl-1 pr-1" style="border: 1px solid red; border-radius: 5px">{{ number_format($exam->price, 0, ',', '.') }} VND</div>
                            @else
                            <div class="text-primary d-inline-block pl-1 pr-1" style="border: 1px solid #51be78; border-radius: 5px">Miễn phí</div>
                            @endif
                        </div>
                        <div class="ml-auto d-flex">
                            @if($exam->price > 0 && !$exam->isPaidByUser(auth()->id()))
                            <form action="{{ url('/vnpay_payment') }}" method="POST">
                                @csrf
                                <input name="id_exam" value="{{ $exam->id }}" type="hidden">
                                <input name="price" value="{{ $exam->price }}" type="hidden">
                                <button type="submit" name="redirect" class="btn btn-primary">Thanh toán</button>
                            </form>
                            @else
                            <a href="/practice-listening/part1/detail/{{ $exam->id }}" class="btn btn-primary">Bắt đầu</a>
                            @endif
                            <a href="/practice-listening/history/{{ $exam->id }}" class="btn btn-outline-primary ml-2">Xem lịch sử</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="m-4 text-center">
                <h4>Chưa có đề thi!</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection