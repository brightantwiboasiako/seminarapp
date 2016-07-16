@extends('layouts.admin')

@section('title')
Participants | {{ e($seminar->title) }}
@endsection

@section('css')
        <!-- CSS Page Style -->
<link rel="stylesheet" href="{{ asset('assets/css/pages/profile.css') }}">

<!-- CSS Theme -->
<link rel="stylesheet" href="{{ asset('assets/css/theme-colors/default.css') }}" id="style_color">
<link rel="stylesheet" href="{{ asset('assets/css/theme-skins/dark.css') }}">

<!-- CSS Customization -->
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <style>
        .table td{
            padding: 5px !important;
        }

        .service-block-u{
            background: none !important;
        }

        .show-more{
            text-align: center;
            margin: 10px 5px;
        }
    </style>

@endsection


@section('js')

    <script>

        var vm = new Vue({
            el: '#container',

            data: {
                participants: [],
                slug: '',
                search: null,
                order: 'surname',
                limit: 10,
                totalCheckIns: 0
            },

            methods: {

                download: function(){
                    window.location = baseUrl() + '/admin/seminar/' + this.slug + '/download';
                },

                showMore: function(){
                    if(this.limit < this.participants.length){
                        this.limit += 10;
                    }
                },

                showAll: function(){
                    this.limit = this.participants.length + 1;
                },

                totalPresent: function(){
                    var present = this.participants.filter(function(participant){
                        return participant.in && participant.in == true;
                    });

                    return present.length;
                },

                checkedIn: function(participant){

                    if(participant.in && participant.in == true){
                        return ' <span class="text-success"><i class="fa fa-check-square"></i></span>';
                    }else{
                        return ' <span class="text-warning"><i class="fa fa-times-circle"></i></span>';
                    }

                },

                showGender: function(participant){
                    if(participant.gender === 'male'){
                        return 'Male';
                    }  else{
                        return 'Female';
                    }
                },

                showProgramme: function(participant){
                    switch(participant.programme){
                        case 'actuarial':
                            return 'Actuarial Science';
                            break;
                        case 'mathematics':
                            return 'Mathematics';
                            break;
                        case 'statistics':
                            return 'Statistics';
                            break;
                        case 'computer-science':
                            return 'Computer Science';
                            break;
                        case 'economics':
                            return 'Economics';
                            break;
                        case 'business-administration':
                            return 'Business Administration';
                            break;
                        case 'engineering':
                            return 'Engineering';
                        break;
                        case 'social-science':
                            return 'Social Science';
                        break;
                        default:
                            return participant.programme_other;
                    }
                },

                showInstitution: function(participant){
                    switch(participant.institution){
                        case 'knust':
                            return 'KNUST';
                        break;
                        case 'ug':
                            return 'UG';
                        break;
                        case 'ucc':
                            return 'UCC';
                        break;
                        case 'uds':
                            return 'UDS';
                        break;
                        case 'umat':
                            return 'UMAT';
                        break;
                        case 'uhas':
                            return 'UHAS';
                        break;
                        default:
                            return participant.institution_other;
                    }
                },

                fetchParticipants: function(){
                    var model = this;
                    this.$http.get(baseUrl() + '/api/seminar/' + this.slug + '/participants')
                            .then(function(response){
                                model.participants = JSON.parse(response.data);
                                model.drawGraphs();
                                model.totalCheckIns = model.totalPresent();
                            }, function(response){
                                alert(response.body);
                            });
                },

                drawGraphs: function(){
                    // institutions
                    this.renderInstitutionsGraph();
                    // gender
                    this.renderGenderGraph();
                    // programmes
                    this.renderProgrammesGraph();
                },

                renderProgrammesGraph: function(){
                    var model = this;
                    var canvas = $('#programmes');
                    var dataSets = [];
                    var programmes = [ 'Actuarial', 'Mathematics', 'Statistics',
                        'Computer-Science', 'Economics', 'Business-Administration', 'Engineering', 'Social-Science',
                        'OTHER'];

                    programmes.forEach(function(programme){
                        dataSets.push(model.participants.filter(function(participant){
                            return participant.programme == programme.toLowerCase();
                        }).length);
                    });


                    var data = {
                        labels: programmes,
                        datasets: [
                            {
                                label: 'Distribution of participants per programmes',
                                data: dataSets,
                                backgroundColor: "rgba(52, 152, 219, .8)",
                                borderColor: "#3498db",
                                borderWidth: 1,
                                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                                hoverBorderColor: "rgba(255,99,132,1)"
                            }]
                    };

                    return new Chart(canvas, {
                        type: 'bar',
                        data: data
                    });
                },

                renderGenderGraph: function(){
                    var model = this;
                    var canvas = $('#gender');
                    var dataSets = [];

                    var gender = ['Male', 'Female'];

                    gender.forEach(function(g){
                        dataSets.push(model.participants.filter(function(participant){
                            return participant.gender == g.toLowerCase();
                        }).length);
                    });

                    var data = {
                        labels: gender,
                        datasets: [
                            {
                                data: dataSets,
                                backgroundColor: [
                                    "#FF6384",
                                    "#36A2EB",
                                    "#FFCE56"
                                ],
                                hoverBackgroundColor: [
                                    "#FF6384",
                                    "#36A2EB",
                                    "#FFCE56"
                                ]
                            }]
                    };

                    return new Chart(canvas, {
                        type: 'pie',
                        data: data
                    });

                },

                renderInstitutionsGraph: function(){
                    var model = this;
                    var canvas = $('#institutions');
                    var dataSets = [];
                    var institutions = [ 'KNUST', 'UG', 'UCC', 'UDS', 'UMAT', 'UHAS', 'OTHER'];

                    institutions.forEach(function(institution){
                        dataSets.push(model.participants.filter(function(participant){
                            return participant.institution == institution.toLowerCase();
                        }).length);
                    });


                    var data = {
                        labels: institutions,
                        datasets: [
                            {
                                label: 'Distribution of participants per institutions',
                                data: dataSets,
                                backgroundColor: "rgba(52, 152, 219, .8)",
                                borderColor: "#3498db",
                                borderWidth: 1,
                                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                                hoverBorderColor: "rgba(255,99,132,1)"
                            }]
                    };

                    return new Chart(canvas, {
                        type: 'bar',
                        data: data
                    });
                }
            },

            ready: function(){
                var model = this;
                setInterval(function(){
                    model.fetchParticipants();
                }, 60000);
                this.fetchParticipants();

            }
        });

    </script>


@endsection


@section('content')
    @include('includes.navigation')
    <div class="container content profile" id="container">
        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>
        <div class="row" v-cloak>
            <!--Left Sidebar-->
            @include('includes.admin.left-sidebar')

            <!-- Profile Content -->
            <div class="col-md-9">
                <div class="profile-body">
                    <!--Service Block v3-->
                    <div class="row margin-bottom-10">
                        <div class="col-sm-12 sm-margin-bottom-20">
                            <div class="service-block-v3 service-block-u">
                                <canvas id="programmes" width="400" height="120"></canvas>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="service-block-v3 service-block-u">
                                <canvas id="institutions" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="service-block-v3 service-block-u">
                                <canvas id="gender" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div><!--/end row-->
                    <!--End Service Block v3-->

                    <hr>

                    <!--Profile Blog-->
                    <div class="panel panel-profile">
                        <div class="panel-heading overflow-h">
                            <h2 class="panel-title heading-sm pull-left"><i class="fa fa-users"></i>
                                Participants <span class="badge">@{{ participants.length }}</span> | </h2>
                                <h2 class="panel-title heading-sm pull-left"><i class="fa fa-check"></i>
                                <span class="badge">@{{ totalCheckIns }}</span> Present &nbsp;</h2>
                                <h2 class="panel-title heading-sm pull-left">
                                    <button @click="download" type="button" class="btn btn-sm btn-default"><i class="fa fa-download"></i> Download</button>
                                </h2>
                            <div class="pull-right">
                                <input type="text" v-model="search" class="form-control" placeholder="Search"/>
                            </div>
                            <div class="pull-right">
                                <select v-model="order" class="form-control">
                                    <option value="surname">Order by: Surname</option>
                                    <option value="first_name">First Name</option>
                                    <option value="gender">Gender</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Institution</th>
                                                <th>Programme</th>
                                                <th class="text-center">Year of completion</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(key, participant) in participants | filterBy search | limitBy limit | orderBy order">
                                                <td class="text-center">@{{{ (key + 1) + checkedIn(participant) }}}</td>
                                                <td>@{{ participant.surname + ' ' + participant.first_name }}</td>
                                                <td>@{{ showGender(participant) }}</td>
                                                <td>@{{ participant.email }}</td>
                                                <td>@{{ participant.phone }}</td>
                                                <td>@{{ showInstitution(participant) }}</td>
                                                <td>@{{ showProgramme(participant) }}</td>
                                                <td class="text-center">@{{ participant.completion_year }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="show-more" v-show="limit < participants.length">
                                            <button class="btn btn-success btn-sm" @click="showMore">Show More</button>
                                            <button class="btn btn-default btn-sm" @click="showAll">Show All</button>
                                        </div>
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