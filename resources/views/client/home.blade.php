@extends('client.layouts.app')
@section('title', config('app.name'). ' - Home')
@section('content')
<div class="hero-slide owl-carousel">
    <div class="intro-section" style="background-image: url('https://marquettewire.org/wp-content/uploads/2022/03/DSC_7669-900x600.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                    <h1>Success with <br> TOEIC Practice!</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-section" style="background-image: url('https://education.ec.europa.eu/sites/default/files/2022-01/study-online-header-1200.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                    <h1>You Can Learn Anything</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-6 mb-5">
                <h2 class="section-title-underline mb-5">
                    <span>Chinh phục TOEIC cùng chúng tôi!</span>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">

                <div class="feature-1 border">
                    <div class="icon-wrapper bg-primary">
                        <span class="flaticon-mortarboard text-white"></span>
                    </div>
                    <div class="feature-1-content">
                        <h2>Bài tập đa dạng</h2>
                        <p>Cung cấp nhiều loại bài tập Reading và Listening</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="feature-1 border">
                    <div class="icon-wrapper bg-primary">
                        <span class="flaticon-school-material text-white"></span>
                    </div>
                    <div class="feature-1-content">
                        <h2>Hỗ trợ phân tích kết quả</h2>
                        <p>Tích hợp AI phân tích điểm mạnh, điểm yếu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="feature-1 border">
                    <div class="icon-wrapper bg-primary">
                        <span class="flaticon-library text-white"></span>
                    </div>
                    <div class="feature-1-content">
                        <h2>Nhắc nhở luyện tập</h2>
                        <p>Duy trì lịch trình luyện tập hiệu quả thông qua email nhắc nhở.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection