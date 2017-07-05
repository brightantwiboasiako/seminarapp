@extends('layouts.frontend')

@section('title')
    Register | {{ e($seminar->title) }}
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
            baseUrl() + "/assets/img/bg/25.jpg",
            baseUrl() + "/assets/img/bg/16.jpg",
        ], {
            fade: 1000,
            duration: 7000
        });
    </script>

    <script>

        var formElement = $('.registration-form');

        var vm = new Vue({
           el:  '#reg-block',
            data:{
                surname: '',
                first_name: '',
                gender: '',
                email: '',
                phone: '',
                institution: '',
                programme: '',
                completion_year: '',
                slug: '',
                institution_other: '',
                programme_other: ''
            },

            methods: {
                processRegistration: function(){

                    var model = this;

                    setProcess(formElement.find('.btn-submit'));
                    bindValidator(formElement, 'Register', function(form){
                        model.$http.post(baseUrl() + '/seminar/register', model.$data)
                                .then(function(response){
                                    data = response.data;
                                    return model.handleRegistrationResponse(data);
                                }, function(response){

                                    cancelProcess(formElement.find('.btn-submit'),'Register');

                                    if(response.status === 422){
                                        bindErrors(JSON.parse(response.data).errors, $('.registration-form'));
                                    }else{
                                        alert('There was a problem while registering you. Please try again.', 'danger');
                                    }

                                });
                    });


                },

                handleRegistrationResponse: function(data){

                    alert('You have been registered successfully. See you around!', 'success', function(){
                        window.location = baseUrl() + '/' + vm.$data.slug;
                    });

                    cancelProcess(formElement.find('.btn-submit'),'Register');
                }
            },

            ready: function(){
                var formElement = $('.registration-form');
                bindValidator(formElement, 'Register', function(form){

                });
            }
        });



    </script>

@endsection


@section('content')
        <div class="reg-block" id="reg-block">
            <form class="registration-form" @submit.prevent="processRegistration">
                <div class="reg-block-header">
                    <h2><a href="{{ url(e($seminar->slug)) }}">{{ e($seminar->title) }}</a></h2>
                    <p>Already Registered? Get directions <a class="color-green" href="{{ url(e($seminar->slug).'/directions') }}">here</a>.</p>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control validate[required,minSize[2]]" v-model="surname" name="surname" placeholder="Surname">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control validate[required,minSize[2]]" name="first_name" v-model="first_name" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-male"></i></span>
                        <select v-model="gender" class="form-control validate[required]" name="gender">
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-30">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" class="form-control validate[required,custom[email]]" name="email" placeholder="Email" v-model="email">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-30">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control validate[required,minSize[10]]" name="phone" placeholder="Phone Number" v-model="phone">
                    </div>
                </div>

                <hr>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20 institution">
                        <span class="input-group-addon"><i class="fa fa-institution"></i></span>
                        <select v-model="institution" class="form-control validate[required]"
                                name="institution" v-show="institution != 'other'">
                            <option value="">Institution</option>
                            <option value="knust">KNUST</option>
                            <option value="ug">UG</option>
                            <option value="ucc">UCC</option>
                            <option value="uds">UDS</option>
                            <option value="umat">UMAT</option>
                            <option value="uhas">UHAS</option>
                            <option value="other">OTHER</option>
                        </select>
                        <input type="text" v-model="institution_other"
                               class="form-control validate[required]" placeholder="Enter your institution"
                               v-show="institution == 'other'" name="institution_other"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                        <select v-model="programme" class="form-control validate[required]" name="programme"
                            v-show="programme != 'other'"
                        >
                            <option value="">Programme</option>
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
                        <input type="text" v-model="programme_other"
                               class="form-control validate[required]" placeholder="Enter your programme"
                               v-show="programme == 'other'" name="programme_other"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <select v-model="completion_year" class="form-control validate[required]" name="completion_year">
                            <option value="">Year of Completion</option>
                            @for($i = (\Carbon\Carbon::now()->format('Y') + 5); $i > \Carbon\Carbon::now()->format('Y') - 10; $i--)
                                <option value="{{ e($i) }}">{{ e($i) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>
                        <button type="submit" class="btn-u btn-block btn-submit">Register</button>
                        <a href="{{ url(e($seminar->slug)) }}" class="btn btn-block btn-default">
                            <i class="fa fa-arrow-left"></i> Back to Seminar</a>
                    </div>
                </div>
            </form>
        </div>
@endsection