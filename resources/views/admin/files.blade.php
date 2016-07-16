@extends('layouts.admin')

@section('title')
    Files | {{ e($seminar->title) }}
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
                slug: null,
                url: null
            },

            methods: {
                save: function(){
                    var model = this;
                    this.$http.post(baseUrl() + '/admin/seminar/files-url', model.$data)
                        .then(function(response){
                            if(response.data.OK){
                                alert('Link has been saved successfully.');
                            }else{
                                alert('Link could not be saved. Please try again.', 'danger');
                            }
                        }, function(response){
                            alert('Something went wrong. Please try again.', 'danger');
                        });
                }
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
                    <div class="row">
                        <div class="col-sm-12 margin-bottom-10">
                            <div class="service-block-u">
                                <input type="text" placeholder="Enter the full url of the seminar files (E.g. https://drive.google.com)" v-model="url" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-sm btn-success" @click="save">
                                <i class="fa fa-save"></i> Save
                            </button>
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