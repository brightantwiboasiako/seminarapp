@extends('layouts.admin')

@section('title')
    Comments
@endsection

@section('css')

    <style>

        body{
            background: #000;
        }
        
        .alertify-notifier{
            overflow: hidden;
            position: relative!important;
            margin:10px auto!important;
            width: 70%!important;
            text-align: center!important;
        }

        .ajs-message{
            margin:10px auto!important;
            width: 100%!important;
            background: #000!important;
        }

        .question{
            color: #fff!important;
            margin-bottom: 25px!important;
        }

        .answer{
            background: #fff!important;
            color: #000!important;
            border:1px solid white;
            padding: 15px;
        }

    </style>

@endsection

@section('js')

    <script>

        var vm = new Vue({
            el: '#comments',
            data: {
                comments: [],
                slug: null,
                key: 0,
                delay: 8
            },

            methods: {
                
                showComment: function(){

                    if(this.comments.length > 0 && this.key < this.comments.length){

                        var current = JSON.parse(this.comments[this.key++]);

                        var again = current.again;
                        var date_time = (current.date_time) ? current.date_time : 'No comment';
                        var any_other = (current.any_other) ? current.any_other : 'No comment';

                        var delay = alertify.get('notifier','delay');
                        alertify.set('notifier','delay', this.delay);
                        var notification = alertify.success(
                            '<h3 class="question"><strong><i class="fa fa-question-circle"></i> Would you like the programme to be organized again?</strong></h3>' +
                            '<h4 class="answer"> &mdash; &nbsp; <i class="fa fa-quote-left"></i> ' + again + ' <i class="fa fa-quote-right"></i></h4><hr>' +
                            '<h3 class="question"><strong><i class="fa fa-question-circle"></i> What is your view about the timing (Date and Time) of the programme?</strong></h3>' +
                            '<h4 class="answer"> &mdash; &nbsp; <i class="fa fa-quote-left"></i> ' + date_time + ' <i class="fa fa-quote-right"></i></h4><hr>' + 
                            '<h3 class="question"><strong><i class="fa fa-question-circle"></i> Any other thing to know?</strong></h3>' +
                            '<h4 class="answer"> &mdash; &nbsp; <i class="fa fa-quote-left"></i> ' + any_other + ' <i class="fa fa-quote-right"></i></h4>'
                        );
                        //alertify.set('notifier','delay', delay);

                        $('.alertify-notifier').removeClass('ajs-bottom');
                        $('.alertify-notifier').removeClass('ajs-right');

                        var model = this;
                        notification.ondismiss = function(){
                            setTimeout(function(){
                                model.showComment();
                            }, 1000);
                        }

                    }else if(this.key == this.comments.length){
                        this.key = 0;
                        var model = this;
                        setTimeout(function(){
                            model.showComment();
                        }, 1000);
                    }else{
                        var model = this;
                        setTimeout(function(){
                            model.showComment();
                        }, 1000);
                    }

                },

                fetchComments: function(){
                    var model = this;
                    this.$http.get(baseUrl() + '/api/seminar/' + this.slug + '/comments')
                        .then(function(response){
                            model.comments = JSON.parse(response.data)
                            // model.showComment();
                        }, function(errorResponse){
                            console.log(errorResponse);
                        });
                }

            },

            ready: function(){
                // Get comments from server
                var model = this;
                setInterval(function(){
                    model.fetchComments();
                }, 30000);
                this.fetchComments();

                this.showComment();

            }
        });


        

    </script>

@endsection

@section('content')
    <div class="comments-container" id="comments">
        <input type="hidden" v-model="slug" value="{{ e($seminar->slug) }}"/>


    </div>
@endsection