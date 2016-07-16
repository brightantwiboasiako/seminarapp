@extends('layouts.admin')

@section('title')
    Settings
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

            <!-- Profile Content -->
            <div class="col-md-6">
                <h2>Change Account Password</h2>   
                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{ e(session('success')) }}</p>                        
                    </div>
                @endif
                <form method="post" action="{{ url('admin/change-password') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Current Password" name="current_password">
                        <div class="has-error">
                            <p class="text-danger">{{ $errors->first('current_password') }}</p>
                        </div>
                    </div> 
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="New Password" name="new_password">
                        <div class="has-error">
                            <p class="text-danger">{{ $errors->first('new_password') }}</p>
                        </div>
                    </div> 
                    <div class="form-group">

                        <button type="submit" class="btn btn-success btn-sm">Change Password</button>
                    </div> 
                </form>            
            </div>
            <!-- End Profile Content -->
        </div>
    </div><!--/container-->
    <!--=== End Profile ===-->
@endsection