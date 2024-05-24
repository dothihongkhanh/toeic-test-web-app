@extends('client.layouts.app')
@section('title', 'Đặt thời gian')
@section('content')
<div class="site-section bg-primary">
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <p class="m-0 font-weight-bold text-primary">Nhận thông báo</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if($notifications->count() > 0)
                        <p>Giờ đã hẹn:</p>
                        <ul class="timeline">
                            @foreach($notifications as $notification)
                            <li>
                                <span>{{ $notification->notification_time }}</span>
                                <form id="delete-form" action="/deleteNotify/{{ $notification->id }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">X</button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        <form method="POST" action="{{ route('client.setNotify') }}">
                            @csrf
                            <p>Chọn giờ</p>
                            <div class="d-flex justify-content-center align-items-center">
                                <input type="time" name="notify_time" class="form-control" required>
                                <button type="submit" class="btn btn-primary ml-2">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection