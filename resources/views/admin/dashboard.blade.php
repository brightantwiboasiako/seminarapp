@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('css')

@endsection

@section('js')

    <script>

        var vm = new Vue({
            el: '#seminars',
            data: {
                seminars: [],
                newSeminar: {},
                selected: {}
            },

            methods: {
                startsAt: function(seminar){
                    return new Date(seminar.date).toLocaleString();
                },

                createSeminar: function(){

                    var infoContainer = $('.processing');

                    pushInfo(infoContainer, '<i class="fa fa-spinner fa-spin"></i>');

                    this.$http.post(baseUrl() + '/admin/seminar/create', vm.newSeminar)
                            .then(function(response){
                                if(!response.data.OK){
                                    vm.handleErrors(response.data.errors);
                                    clearInfo(infoContainer);
                                }else{
                                    vm.seminars.push(vm.newSeminar);
                                    vm.newSeminar = {};
                                    pushInfo(infoContainer,'<i class="fa fa-check"></i> Created!');
                                }

                            }, function(errorResponse){
                                $('.error').html(errorResponse.data);
                                clearInfo(infoContainer);
                            });
                },

                modifySelected: function(){
                    var infoContainer = $('.processing');

                    pushInfo(infoContainer, '<i class="fa fa-spinner fa-spin"></i>');

                    this.$http.post(baseUrl() + '/admin/seminar/edit', vm.selected)
                            .then(function(response){
                                if(!response.data.OK){
                                    vm.handleErrors(response.data.errors);
                                    clearInfo(infoContainer);
                                }else{
                                    pushInfo(infoContainer,'<i class="fa fa-check"></i> Modified!');
                                }

                            }, function(errorResponse){
                                $('.error').html(errorResponse.data);
                                clearInfo(infoContainer);
                            });
                },

                handleErrors(errors){
                    console.log(errors);
                },

                title: function(seminar){
                    return '<a href="'+ baseUrl() +'/admin/seminar/'+ seminar.slug +'">'+ seminar.title +'</a>';
                },

                edit: function(seminar){
                    this.selected = seminar;
                },

                deleteSeminar: function(seminar){
                    var model = this;
                    confirm('Are you sure you want to delete ' + seminar.title + '? This action cannot be undone!', function(){
                        
                        model.$http.post(baseUrl() + '/admin/seminar/' + seminar.slug + '/delete', {
                            slug: seminar.slug
                        }).then(function(response){
                            alert(seminar.title + ' has been deleted successfully', 'success', function(){
                                window.location.reload();
                            });
                        }, function(response){
                            alert('Seminar could not be deleted. Please try again.', 'danger');
                        });

                    }, function(){

                    });
                }
            },

            ready: function(){
                // Get seminars from server
                this.$http.get(baseUrl() + '/api/seminars')
                        .then(function(response){
                            vm.seminars = JSON.parse(response.data)
                        }, function(errorResponse){
                            console.log(errorResponse);
                        });
            }
        });


        $('.datetime').datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });

    </script>

@endsection

@section('content')
    @include('includes.navigation')
    <div class="seminars-container" id="seminars">
        <div class="heading">
            <div class="title clearfix">
                <h2 class="pull-left">Seminars</h2>
                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-seminar">
                        <i class="fa fa-plus"></i> New Seminar
                    </button>
                    @include('includes.modals.create-seminar')
                    @include('includes.modals.edit-seminar')
                </div>
            </div>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th><i class="fa fa-map-marker"></i> Location</th>
                            <th><i class="fa fa-clock-o"></i> Starts at</th>
                            <th><i class="fa fa-cog"></i> Settings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(key, seminar) in seminars">
                            <td>@{{ key + 1 }}</td>
                            <td>@{{{ title(seminar) }}}</td>
                            <td>@{{ seminar.location }}</td>
                            <td>@{{ startsAt(seminar) }}</td>
                            <td>
                                <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#edit-seminar" title="Edit" @click="edit(seminar)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-xs btn-danger" title="Delete" @click="deleteSeminar(seminar)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr v-show="seminars.length === 0">
                            <td colspan="4"><p>No Seminars found!</p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection