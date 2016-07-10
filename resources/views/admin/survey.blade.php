@extends('layouts.admin')

@section('title')
    Survey | {{ e($seminar->title) }}
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

        .graph{
            border: 1px solid grey;
            padding: 10px;
        }
    </style>

@endsection


@section('js')

    <script>

        var vm = new Vue({
            el: '#container',

            data: {
                responses: [],
                slug: '',
                distribution: 'school',
                selections: ['Very Good', 'Good', 'Average', 'Poor', 'Very Poor'],
                data: {}
            },

            methods: {

                fetchSurveyResponses: function(){
                    var model = this;
                    this.$http.get(baseUrl() + '/api/seminar/' + this.slug + '/survey')
                            .then(function(response){
                                model.parseResponses(response.data);
                                model.responses = JSON.parse(response.data);
                                model.drawGraph();
                            }, function(response){
                                alert(response.body);
                            });
                },

                parseResponses: function(response){
                    var data = JSON.parse(response);

                    console.log(data);
                },


                setData: function(){
                    this.data = this.responses[this.distribution];
                },

                toArray: function(obj){
                    var arr = [];
                    for(var i = 0; i < obj.length; i++){
                        arr.push(obj[i]);
                    }

                    console.log(arr);

                    return arr;
                },

                plotGraph: function(){
                    if(this.distribution == 'publicity'){
                        this.plot(this.toArray(this.data.online), 'online', 'Convenience of online platform');
                        this.plot(this.toArray(this.data.online), 'publicity', 'Publicity');
                        this.plot(this.toArray(this.data.online), 'refereshment', 'Refreshments');
                    }else if(this.distribution == 'QandA'){
                        this.plot( this.toArray(this.data.presentation_mode), 'presentation_mode', 'Mode of presentation');
                        this.plot( this.toArray(this.data.answers), 'answers', 'Answers to questions');
                        this.plot( this.toArray(this.data.duration), 'duration', 'Duration');
                    }else{
                        this.plot(this.toArray(this.data.time), 'time', 'Timely manner of presentation');
                        this.plot( this.toArray(this.data.presentation_mode), 'presentation_mode', 'Mode of presentation');
                        this.plot( this.toArray(this.data.presenter_clarity), 'presenter_clarity', 'Clarity of presenter');
                        this.plot( this.toArray(this.data.topic_coverage), 'topic_coverage', 'Depth of topic covered');
                    }
                },

                plot: function(plotData, id, title){

                    var container = $('.graph-container');

                    container.append('<div class="col-md-6 graph"><h4></h4><canvas id="canvas-'+id+'" width="400" height="200"></canvas></div>');

                    var canvas = $('#canvas-'+id);

                    canvas.siblings('h4').text(title);

                    var data = {
                        labels: this.selections,
                        datasets: [
                            {
                                data: plotData,
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

                drawGraph: function(){

                    this.setData();

                    var container = $('.graph-container');
                    container.html('');

                    return this.plotGraph();

                }

            },

            ready: function(){
                var model = this;
                setInterval(function(){
                    model.fetchSurveyResponses();
                }, 60000);
                this.fetchSurveyResponses();

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
                                <h2>View Survey Distribution</h2>
                                <select class="form-control" @change="drawGraph" v-model="distribution">
                                    <option value="school">School Search & Applications</option>
                                    <option value="visa">Visa Application Process</option>
                                    <option value="funding">Funding and Scholarships</option>
                                    <option value="exams">SOA, IFoA and CAS Exams</option>
                                    <option value="tests">Standardised Tests</option>
                                    <option value="iaba">IABA- Annual Meeting, Boot Camp and Scholarships</option>
                                    <option value="publicity">Publicity and Refreshments</option>
                                    <option value="QandA">Questions and Answers</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="service-block-v3 service-block-u graph-container row">

                            </div>
                        </div>
                    </div><!--/end row-->
                    <!--End Service Block v3-->

                    <hr>
                </div>
            </div>
            <!-- End Profile Content -->
        </div>
    </div><!--/container-->
    <!--=== End Profile ===-->
@endsection