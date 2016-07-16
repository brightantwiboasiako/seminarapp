@extends('layouts.frontend')

@section('title')
    Check-In | {{ e($seminar->title) }}
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
            font-size: 45px;
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


        var vm = new Vue({

            el: '.content-md',
            data: {
                email: '',
                slug: '',
                processing: false
            },

            methods: {

                checkIn: function(){
                    this.processing = true;
                    var model = this;
                    this.$http.post(baseUrl() + '/' + this.slug + '/in', this.$data)
                            .then(function(response){

                                model.processing = false;
                                var data = response.data;
                                if(!data.OK){
                                    alert(data.message, 'danger');
                                }else{
                                    alert('We now know that you are around! Welcome.');
                                }
                            }, function(response){
                                alert('We could not check you in. Please try again.', 'danger');
                                model.processing = false;
                            });
                }

            }

        });


    </script>
    @endsection

    @section('content')
            <!-- Interactive Slider v2 -->
    <div class="interactive-slider-v2 img-v4">
        <div class="container">
            <h1>{{ e($seminar->title) }}</h1>
            <hr>
            <h3><i class="fa fa-user"></i> Check In</h3>
            <h2>
                <a href="{{ url(e($seminar->slug)) }}" class="btn btn-sm btn-success"> 
                    <i class="fa fa-arrow-left"></i>
                    Back to Seminar
                </a>
            </h2>
        </div>
    </div>
    <!-- End Interactive Slider v2 -->
    <div class="content-md">
        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>
        <div class="container">
            <!-- Service Box -->
            <div class="row text-center margin-bottom-60">

                <div class="col-md-6 col-md-offset-3">
                    <div class="input-group">
                        <input type="text" v-model="email" placeholder="Please enter your email address"
                               class="form-control" @keyup.enter="checkIn" autofocus autocomplete="off"/>
                        <span class="input-group-addon" @click="checkIn" v-show="processing === false">
                            <i class="fa fa-sign-in"></i>
                        </span>
                        <span class="input-group-addon" @click="checkIn" v-show="processing === true">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </div>

                </div>

            </div>
            <!-- End Service Box -->
        </div><!--/container -->
    </div>
    <!--=== End Content ===-->
@endsection