@extends('layouts.frontend')

@section('title')
    {{ e($seminar->title) }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/parallax-slider/css/parallax-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fancybox/source/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">

    <style>
        .interactive-slider-v2{
            padding: 80px 0;
        }

        .interactive-slider-v2 h3{
            color: #fff !important;
        }

        div.disabled{
            cursor: not-allowed;
            opacity: .7;
        }
    </style>

@endsection

@section('js')

    <script type="text/javascript" src="{{ asset('assets/plugins/jquery.parallax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/parallax-slider/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/parallax-slider/js/jquery.cslider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/fancybox/source/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/owl-carousel/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/fancy-box.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/owl-carousel.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
            App.initParallaxBg();
            FancyBox.initFancybox();
            OwlCarousel.initOwlCarousel();
            StyleSwitcher.initStyleSwitcher();
        });
    </script>
    @endsection

    @section('content')
            <!-- Interactive Slider v2 -->
    <div class="interactive-slider-v2 img-v4">
        <div class="container">
            <h1>{{ e($seminar->title) }}</h1>
            <hr>
            <h3><i class="fa fa-map-marker"></i> {{ e($seminar->location()) }}</h3>
            <p><i class="fa fa-calendar"></i> {{ e($seminar->date()) }}</p>
            <p><i class="fa fa-clock-o"></i> {{ e($seminar->time()) }}</p>
        </div>
    </div>
    <!-- End Interactive Slider v2 -->
    <div class="content-md">
        <div class="container">
            <!-- Service Box -->
            <div class="row text-center margin-bottom-60">

                @if($seminar->registrationClosed())
                    <div class="disabled" title="Registration is closed for this seminar.">
                        <div class="col-md-4 md-margin-bottom-50">
                            <i class="fa fa-user fa-5x"></i>
                            <h1 class="title-v3-md margin-bottom-10">Register</h1>
                            <p>Let us know you are coming so we can get things right and serve you better!</p>
                        </div>
                    </div>
                @else
                    <a href="{{ url(e($seminar->slug).'/register') }}">
                        <div class="col-md-4 md-margin-bottom-50">
                            <i class="fa fa-user fa-5x"></i>
                            <h1 class="title-v3-md margin-bottom-10">Register</h1>
                            <p>Let us know you are coming so we can get things right and serve you better!</p>
                        </div>
                    </a>
                @endif


                @if(!$seminar->surveyOpen())
                    <div class="disabled" title="Survey only available during seminar.">
                        <div class="col-md-4 md-margin-bottom-50">
                            <i class="fa fa-bar-chart fa-5x"></i>
                            <h1 class="title-v3-md margin-bottom-10">Take Survey</h1>
                            <p>Tell us how you think we did in meeting your expectations. Only takes minutes!</p>
                        </div>
                    </div>
                @else
                    <a href="{{ url(e($seminar->slug).'/survey') }}">
                        <div class="col-md-4 flat-service md-margin-bottom-50">
                            <i class="fa fa-bar-chart fa-5x"></i>
                            <h1 class="title-v3-md margin-bottom-10">Take Survey</h1>
                            <p>Tell us how you think we did in meeting your expectations. Only takes minutes!</p>
                        </div>
                    </a>
                @endif

                @if($seminar->closed())

                    @if($seminar->filesDownloadLinkAvailable())
                        <a href="{{ url(e($seminar->filesUrl())) }}" target="_blank">
                            <div class="col-md-4 flat-service">
                                <i class="fa fa-download fa-5x"></i>
                                <h2 class="title-v3-md margin-bottom-10">Download Seminar Files</h2>
                                <p>Get all the materials you need here</p>
                            </div>
                        </a>
                    @else
                        <div class="disabled" title="Files download link not available.">
                            <div class="col-md-4 flat-service">
                                <i class="fa fa-download fa-5x"></i>
                                <h2 class="title-v3-md margin-bottom-10">Download Seminar Files</h2>
                                <p>Get all the materials you need here</p>
                            </div>
                        </div>
                    @endif
                @elseif($seminar->ongoing())
                    <a href="{{ url(e($seminar->slug).'/in') }}">
                        <div class="col-md-4 flat-service">
                            <i class="fa fa-check fa-5x"></i>
                            <h2 class="title-v3-md margin-bottom-10">Check In</h2>
                            <p>Let us know that you are already around.</p>
                        </div>
                    </a>
                @else
                    <div class="disabled" title="You can only check in during seminar.">
                        <div class="col-md-4 flat-service">
                            <i class="fa fa-check fa-5x"></i>
                            <h2 class="title-v3-md margin-bottom-10">Check In</h2>
                            <p>Let us know that you are already around.</p>
                        </div>
                    </div>
                @endif    
            </div>
            <!-- End Service Box -->
        </div><!--/container -->
    </div>
    <!--=== End Content ===-->
@endsection