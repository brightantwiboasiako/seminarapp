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
            @include('includes.admin.left-sidebar')

            <!-- Profile Content -->
            <div class="col-md-9">
                <div class="profile-body">
                    <!--Service Block v3-->
                    <div class="row margin-bottom-10">
                        <div class="col-sm-6 sm-margin-bottom-20">
                            <div class="service-block-v3 service-block-u">
                                <i class="icon-users"></i>
                                <span class="service-heading">Total Participants</span>
                                <span class="counter">{{ e(number_format($seminar->getTotalParticipants())) }}</span>

                                <div class="clearfix margin-bottom-10"></div>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="service-block-v3 service-block-blue">
                                <i class="icon-screen-desktop"></i>
                                <span class="service-heading">Survey Responses</span>
                                <span class="counter">{{ e(number_format($seminar->getTotalResponses())) }}</span>

                                <div class="clearfix margin-bottom-10"></div>
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
                                            <li><i class="fa fa-bell"></i>
                                                {{ e($seminar->getTotalParticipants()) }} {{ str_plural('Participant', $seminar->getTotalParticipants()) }}</li>
                                            <li><i class="fa fa-group"></i>{{ e($seminar->getTotalResponses()) }} {{ str_plural('Response', $seminar->getTotalResponses()) }}</li>
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