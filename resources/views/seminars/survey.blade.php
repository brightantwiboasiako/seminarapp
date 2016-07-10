@extends('layouts.frontend')

@section('title')
    Survey | {{ e($seminar->title) }}
@endsection

@section('css')

    {{--<link rel="stylesheet" href="{{ asset('assets/plugins/line-icons/line-icons.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') }}">
    <!--[if lt IE 9]><link rel="stylesheet" href="{{ asset('assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css') }}"><![endif]-->

    <style>
        .welcome, .completed{
            margin-top: 15%;
        }

        .completed{
            opacity: 0;
        }

        .questions{
            margin-top: 2%;
        }

        .radio{
            padding: 5px;
        }

        .selected{
            background: #72c02c;
            color: #fff !important;
        }



    </style>

@endsection

@section('js')

    <script>

        var vm = new Vue({
           el: '#container',
           data: {
               started: false,

               last: false,

               completed: false,

               key: 0,

               slug: null,

               active: {},

               responses: [
                   "Very Good", "Good", "Average", "Poor", "Very Poor"
               ],

               categories: [
                   {
                       id: "school",
                       title: "School Search & Applications",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "visa",
                       title: "Visa Application Process",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "funding",
                       title: "Funding and Scholarships",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "exams",
                       title: "SOA, IFoA and CAS Exams",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "tests",
                       title: "Standardised Tests",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "iaba",
                       title: "IABA- Annual Meeting, Boot Camp and Scholarships",
                       questions: [
                           { id: "time", q: "Timely manner of presentation", selected: null},
                           { id: "topic_coverage", q: "Depth of topic covered", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null},
                           { id: "presenter_clarity", q: "Clarity of presenter", selected: null}
                       ]
                   },
                   {
                       id: "publicity",
                       title: "Publicity and Refreshments",
                       questions: [
                           { id: "publicity", q: "Publicity", selected: null},
                           { id: "refreshment", q: "Refreshments", selected: null},
                           { id: "online", q: "Convenience of online platform", selected: null}
                       ]
                   },
                   {
                       id: "QandA",
                       title: "Questions and Answers",
                       questions: [
                           { id: "answers", q: "Answers to questions", selected: null},
                           { id: "duration", q: "Duration", selected: null},
                           { id: "presentation_mode", q: "Mode of presentation", selected: null}
                       ]
                   }
               ],

               answers: []
           },
           methods: {

               select: function(key, response){

                   this.active.questions[key].selected = response;

               },

               submit: function(){
                   var model = this;
                    confirm('Are you sure you want to submit your survey responses', function(){
                        // submit

                        model.$http.post(baseUrl() +'/' + model.slug +  '/survey/response', {
                            responses: model.categories
                        })
                                .then(function(response){
                                    alert('Your responses have been saved!');
                                }, function(response){
                                    alert('Your responses could not be saved. Please try again.', 'danger');
                                });

                        model.completed = true;
                    }, function(){

                    });
               },

               beginSurvey: function(){
                   this.started = true;
                   this.move();
               },

               previous: function(){
                    if(this.key != 0){
                        this.key--;
                    }

                   this.last = false;

                   return this.move();
               },

               next: function(){
                   if(this.key < this.categories.length - 1){
                       this.key++;
                   }else{
                        this.last = true;
                   }

                   return this.move();
               },

               move: function(){
                   this.active = this.categories[this.key];
               }

           },

            ready: function(){
                $('.completed').css('opacity', 1);
            }
        });

    </script>

@endsection


@section('content')
    <div class="container" id="container" v-cloak>
        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>
        <div class="col-md-8 col-md-offset-2 welcome  text-center" v-show="!started">
            <div class="headline"><h2>Welcome to the survey</h2></div>
            <h4>
                Thank you for choosing to participate in this survey. It only takes minutes and it will help us know how you think we did
                and to offer a better service to participants in the future.
                <p class="text-danger">(Please do not refresh your browser during this session.)</p>
            </h4>
            <ul class="pager">
                <li class="begin"><a href="#"  @click="beginSurvey">Begin Survey <i class="fa fa-clock-o"></i></a></li>
            </ul>
        </div>

        <div class="col-md-8 col-md-offset-2 completed  text-center" v-show="completed">
            <div class="headline"><h2>Thanks!</h2></div>
            <h4>
                We really appreciate your time spent on this survey. Your responses will help us serve others better!
            </h4>
            <ul class="pager">
                <li class="begin"><a href="{{ url(e($seminar->slug)) }}"><i class="fa fa-arrow-left"></i> Back to Seminar</a></li>
            </ul>
        </div>

        <div class="col-md-10 col-md-offset-1 questions" v-show="started && !completed">
            <div class="headline">
                <h2>@{{ active.title }}</h2>
            </div>

            <div class="row">
                <div class="question col-md-4" v-for="(key, question) in active.questions">
                    <h4>@{{ question.q }}</h4>
                    <div class="responses">
                        <div class="col col-12 sky-form" v-for="response in responses">
                            <label class="radio @{{ question.selected == response ? 'selected' : '' }}">
                                <input type="radio" @click="select(key, response)"
                                name="@{{ active.id + '_' +question.id }}"/>
                                {{--<i class="rounded-x"></i> --}}
                                @{{ response }}
                            </label>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 pager-container">
                    <ul class="pager">
                        <li><a @click="previous" class="rounded-4x" href="#">Previous</a></li>
                        <li v-show="!last"><a  @click="next" class="rounded-4x" href="#">Next</a></li>
                        <li v-show="last"><a  @click="submit" class="rounded-4x" href="#">Submit</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection