@extends('client.layouts.app')
@section('title', config('app.name'). ' - Home')
@section('content')
<div class="hero-slide owl-carousel">
    <div class="intro-section" style="background-image: url('https://marquettewire.org/wp-content/uploads/2022/03/DSC_7669-900x600.jpg');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 mx-auto text-center" data-aos="fade-up">
                    <h1>Success with  <br> TOEIC Practice!</h1>
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


<div></div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-4 mb-5">
                <h2 class="section-title-underline mb-5">
                    <span>Why Academics Works</span>
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
                        <h2>Personalize Learning</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit morbi hendrerit elit</p>
                        <p><a href="#" class="btn btn-primary px-4 rounded-0">Learn More</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="feature-1 border">
                    <div class="icon-wrapper bg-primary">
                        <span class="flaticon-school-material text-white"></span>
                    </div>
                    <div class="feature-1-content">
                        <h2>Trusted Courses</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit morbi hendrerit elit</p>
                        <p><a href="#" class="btn btn-primary px-4 rounded-0">Learn More</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="feature-1 border">
                    <div class="icon-wrapper bg-primary">
                        <span class="flaticon-library text-white"></span>
                    </div>
                    <div class="feature-1-content">
                        <h2>Tools for Students</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit morbi hendrerit elit</p>
                        <p><a href="#" class="btn btn-primary px-4 rounded-0">Learn More</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="site-section">
    <div class="container">


        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-6 mb-5">
                <h2 class="section-title-underline mb-3">
                    <span>Popular Practice</span>
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="owl-slide-3 owl-carousel">
                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_1.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Mobile Application</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_2.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Web Design</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_3.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Arithmetic</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="courses-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_4.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Mobile Application</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_5.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Web Design</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                    <div class="course-1-item">
                        <figure class="thumnail">
                            <a href="course-single.html"><img src="images/course_6.jpg" alt="Image" class="img-fluid"></a>
                            <div class="price">$99.00</div>
                            <div class="category">
                                <h3>Mobile Application</h3>
                            </div>
                        </figure>
                        <div class="course-1-content pb-4">
                            <h2>How To Create Mobile Apps Using Ionic</h2>
                            <div class="rating text-center mb-3">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                            <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>
                            <p><a href="course-single.html" class="btn btn-primary rounded-0 px-4">Enroll In This Course</a></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>



    </div>
</div>

@endsection