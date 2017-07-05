@extends('layouts.frontend')

@section('title')
    Directions | {{ e($seminar->title) }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/parallax-slider/css/parallax-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fancybox/source/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/owl-carousel/owl.carousel.css') }}">


    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 500px;
        }
        #floating-panel {
            position: absolute;
            top: 10px;
            left: 35%;
            z-index: 5;
            background-color: #fff;
            padding: 5px 10px;
            border: 1px solid #999;
            text-align: left;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
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
    <script src="{{ asset('js/geolocator.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
            App.initParallaxBg();
            FancyBox.initFancybox();
            OwlCarousel.initOwlCarousel();
            StyleSwitcher.initStyleSwitcher();
        });
    </script>

    <script>
        function initMap() {
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {lat: 5.6037, lng: 0.1870}
            });

            directionsDisplay.setMap(map);

            var clientLocationContainer = $('#your-location');
            var seminarVenueContainer = $('#venue');

//            var destination = {
//                lat: 5.569207,
//                lng: -0.220938
//            };

            var onChangeHandler = function() {
                calculateAndDisplayRoute(directionsService, directionsDisplay, clientLocationContainer.val(),
                    seminarVenueContainer.val());
            };
            $('#locate').on('click', onChangeHandler);

            var html5Options = { enableHighAccuracy: true, timeout: 6000, maximumAge: 0 };
            geolocator.locate(function(location){
                clientLocationContainer.val(location.formattedAddress);
                onChangeHandler();
            }, function(){
                alert('We could not find your location. Please enter it to get directions.', 'danger');
            }, true, html5Options);

        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay, origin, destination) {
            directionsService.route({
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING,
                region: 'gh'
            }, function(response, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                } else {
                    alert('We could not find your location. Please enter it to get directions.', 'danger');
                }
            });
        }




    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDquzgxe7zXXRM7dQI0kv70WOQ0HYwtw0E&callback=initMap">
    </script>

    @endsection

    @section('content')
            <!-- Interactive Slider v2 -->
    {{--<div class="interactive-slider-v2 img-v4">--}}
        {{--<div class="container">--}}
            {{--<h1>{{ e($seminar->title) }}</h1>--}}
            {{--<p><i class="fa fa-calendar"></i> Date: {{ e($seminar->date()) }}</p>--}}
            {{--<p><i class="fa fa-clock-o"></i> Time: {{ e($seminar->time()) }}</p>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div>
        <div id="floating-panel">
            <form class="form-inline">
                <b>Your Location: </b>
                <input type="text" class="form-control" id="your-location"/>
                <b>Seminar Venue: </b>
                <input type="text" class="form-control" id="venue" value="{{ e($seminar->location) }}"/>
                <button type="button" class="btn btn-xs btn-primary" id="locate">Locate</button>
            </form>
        </div>
        <div id="map"></div>
    </div>

    <!-- End Interactive Slider v2 -->
    <div class="content-md">
        <div class="container">
            <!-- Service Box -->
            <div class="row text-center margin-bottom-60">
                <a href="{{ url(e($seminar->slug)) }}">
                    <div class="col-md-12 flat-service">
                        <i class="fa fa-arrow-left fa-5x"></i>
                        <h2 class="title-v3-md margin-bottom-10">Back to Seminar</h2>
                    </div>
                </a>
            </div>
            <!-- End Service Box -->
        </div><!--/container -->
    </div>
    <!--=== End Content ===-->
@endsection