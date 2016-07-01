@extends('layouts.frontend')

@section('title')
    {{ e($seminar->title) }} | Register
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/page_log_reg_v2.css') }}">
    <style>
        @media(min-width: 780px){
            .reg-block{
                width: 680px;
            }
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('assets/plugins/backstretch/jquery.backstretch.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
        });
    </script>
    <script type="text/javascript">
        $.backstretch([
            baseUrl() + "/assets/img/bg/19.jpg",
            baseUrl() + "/assets/img/bg/18.jpg",
        ], {
            fade: 1000,
            duration: 7000
        });
    </script>

    <script>

        var vm = new Vue({
           el:  '#reg-block',
            data:{
                surname: '',
                first_name: '',
                gender: '0',
                email: '',
                phone: '',
                institution: '0',
                programme: '0',
                completion_year: '0',
                slug: ''
            },

            methods: {
                processRegistration: function(){
                    this.$http.post(baseUrl() + '/seminar/register', this.$data)
                            .then(function(response){
                                data = response.data;

                                vm.handleRegistrationResponse(data);
                            }, function(response){
                                $('.error').html(response.body);
                            });
                },

                handleRegistrationResponse(data){ console.log(data);
                    if(data.OK){
                        alert('You have been registered successfully. See you around!', 'success', function(){
                            window.location = baseUrl();
                        });
                    }else{
                        if(data.reason == 'validation'){
                            console.log(data.errors);
                            bindErrors(data.errors, $('.registration-form'));
                        }else{
                            alert('Sorry something went wrong! Please try again.');
                        }
                    }
                }
            }
        });

    </script>

@endsection


@section('content')
        <div class="reg-block" id="reg-block">
            <form class="registration-form" @submit.prevent="processRegistration">
                <div class="reg-block-header">
                    <h2><a href="{{ url(e($seminar->slug)) }}">{{ e($seminar->title) }}</a></h2>
                    <p>Already Registered? Click <a class="color-green" href="{{ url(e($seminar->slug).'/survey') }}">here</a> to take a survey.</p>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" v-model="surname" name="surname" placeholder="Surname">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="first_name" v-model="first_name" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-male"></i></span>
                        <select v-model="gender" class="form-control" name="gender">
                            <option value="0">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-30">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control" name="email" placeholder="Email" v-model="email">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-30">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="phone" placeholder="Phone Number" v-model="phone">
                    </div>
                </div>

                <hr>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                        <select v-model="institution" class="form-control" name="institution">
                            <option value="0">Institution</option>
                            <option value="knust">KNUST</option>
                            <option value="ug">UG</option>
                            <option value="ucc">UCC</option>
                            <option value="uds">UDS</option>
                            <option value="umat">UMAT</option>
                            <option value="uhas">UHAS</option>
                            <option value="other">OTHER</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <select v-model="programme" class="form-control" name="programme">
                            <option value="0">Programme</option>
                            <option value="actuarial">Actuarial Science</option>
                            <option value="mathematics">Mathematics</option>
                            <option value="statistics">Statistics</option>
                            <option value="computer-science">Computer Science</option>
                            <option value="economics">Economics</option>
                            <option value="business-administration">Business Administration</option>
                            <option value="engineering">Engineering</option>
                            <option value="social-science">Social Science</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <select v-model="completion_year" class="form-control" name="completion_year">
                            <option value="0">Year of Completion</option>
                            @for($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y') - 20; $i--)
                                <option value="{{ e($i) }}">{{ e($i) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>
                        <button type="submit" class="btn-u btn-block">Register</button>
                    </div>
                </div>
            </form>
        </div>
@endsection