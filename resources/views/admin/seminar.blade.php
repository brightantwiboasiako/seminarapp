@extends('layouts.admin')

@section('title')
    {{ e($seminar->title) }}
@endsection

@section('css')
        <!-- CSS Page Style -->
<link rel="stylesheet" href="{{ asset('assets/css/pages/profile.css') }}">

<!-- CSS Theme -->
<link rel="stylesheet" href="{{ asset('assets/css/theme-colors/default.css') }}" id="style_color">
<link rel="stylesheet" href="{{ asset('assets/css/theme-skins/dark.css') }}">

<!-- CSS Customization -->
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection


@section('js')



@endsection


@section('content')
    @include('includes.navigation')
    <div class="container content profile">
        <div class="row">
            <!--Left Sidebar-->
            <div class="col-md-3 md-margin-bottom-40">
                {{--<img class="img-responsive profile-img margin-bottom-20" src="assets/img/team/img32-md.jpg" alt="">--}}

                <ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">
                    <li class="list-group-item active">
                        <a href="{{ url('admin/seminar/'.e($seminar->slug)) }}"><i class="fa fa-bar-chart-o"></i> {{ e($seminar->title) }}</a>
                    </li>
                    <li class="list-group-item">
                        <a href=""><i class="fa fa-users"></i> Participants</a>
                    </li>
                    <li class="list-group-item">
                        <a href=""><i class="fa fa-bar-chart"></i> Survey</a>
                    </li>
                </ul>


                <div class="margin-bottom-50"></div>

                <!--Datepicker-->
                <form action="#" id="sky-form2" class="sky-form">
                    <div id="inline-start"></div>
                </form>
                <!--End Datepicker-->
            </div>
            <!--End Left Sidebar-->

            <!-- Profile Content -->
            <div class="col-md-9">
                <div class="profile-body">
                    <!--Service Block v3-->
                    <div class="row margin-bottom-10">
                        <div class="col-sm-6 sm-margin-bottom-20">
                            <div class="service-block-v3 service-block-u">
                                <i class="icon-users"></i>
                                <span class="service-heading">Total Participants</span>
                                <span class="counter">52,147</span>

                                <div class="clearfix margin-bottom-10"></div>

                                <div class="row margin-bottom-20">
                                    <div class="col-xs-6 service-in">
                                        <small>Last Week</small>
                                        <h4 class="counter">1,385</h4>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="service-block-v3 service-block-blue">
                                <i class="icon-screen-desktop"></i>
                                <span class="service-heading">Survey Responses</span>
                                <span class="counter">324,056</span>

                                <div class="clearfix margin-bottom-10"></div>

                                <div class="row margin-bottom-20">
                                    <div class="col-xs-6 service-in">
                                        <small>Last Week</small>
                                        <h4 class="counter">26,904</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/end row-->
                    <!--End Service Block v3-->

                    <hr>

                    <!--Profile Blog-->
                    <div class="panel panel-profile">
                        <div class="panel-heading overflow-h">
                            <h2 class="panel-title heading-sm pull-left"><i class="fa fa-info"></i>Seminar Information</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="profile-blog blog-border">
                                        <div class="name-location">
                                            <strong>{{ e($seminar->location) }}</strong>
                                            <span><i class="fa fa-map-marker"></i><a href="#">Directions</a></span>
                                        </div>
                                        <div class="clearfix margin-bottom-20"></div>
                                        <p><i class="fa fa-calendar"></i> Date: {{ e((new \Carbon\Carbon($seminar->date))->format('jS M Y')) }}</p>
                                        <p><i class="fa fa-clock-o"></i> Time: {{ e((new \Carbon\Carbon($seminar->date))->format('H:i')) }}GMT</p>
                                        <hr>
                                        <ul class="list-inline share-list">
                                            <li><i class="fa fa-bell"></i>12 Participants</li>
                                            <li><i class="fa fa-group"></i>54 Responses</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Profile Blog-->
                </div>
            </div>
            <!-- End Profile Content -->
        </div>
    </div><!--/container-->
    <!--=== End Profile ===-->
@endsection