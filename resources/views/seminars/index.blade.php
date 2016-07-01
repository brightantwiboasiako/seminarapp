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
            padding: 140px 0;
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
            <p><i class="fa fa-calendar"></i> Date: {{ e($seminar->date()) }}</p>
            <p><i class="fa fa-clock-o"></i> Time: {{ e($seminar->time()) }}</p>
        </div>
    </div>
    <!-- End Interactive Slider v2 -->
    <div class="content-md">
        <div class="container">
            <!-- Service Box -->
            <div class="row text-center margin-bottom-60">
                <a href="{{ url(e($seminar->slug).'/register') }}">
                    <div class="col-md-4 md-margin-bottom-50">
                        <i class="fa fa-user fa-5x"></i>
                        <h1 class="title-v3-md margin-bottom-10">Register</h1>
                        <p>Let us know you are coming so we can get things right and serve you better!</p>
                    </div>
                </a>
                <a href="{{ url(e($seminar->slug).'/survey') }}">
                    <div class="col-md-4 flat-service md-margin-bottom-50">
                        <i class="fa fa-bar-chart fa-5x"></i>
                        <h1 class="title-v3-md margin-bottom-10">Take Survey</h1>
                        <p>Tell us how you think we are doing in meeting your expectations. Only takes minutes!</p>
                    </div>
                </a>
                <a href="{{ url(e($seminar->slug).'/directions') }}">
                    <div class="col-md-4 flat-service">
                        <i class="fa fa-map-marker fa-5x"></i>
                        <h2 class="title-v3-md margin-bottom-10">Get Directions</h2>
                        <p>Don't know about {{ e($seminar->location) }}? Let's try showing you on the map!</p>
                    </div>
                </a>
            </div>
            <!-- End Service Box -->
        </div><!--/container -->
    </div>
    <!--=== End Content ===-->
@endsection