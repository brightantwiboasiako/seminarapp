@extends('layouts.portal')

@section('title')
    Login
@endsection

@section('content')
    <div class="login-box">
        <div class="header">
            <h2 class="title">Login | <i class="fa fa-lock"></i></h2>
        </div>
        <div class="body">
            <form role="form" method="post" action="{{ url('admin/login') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" name="username" type="text" placeholder="Username"/>
                    <div class="has-error">
                        <p class="text-danger">{{ e($errors->first('username')) }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" name="password" type="password" placeholder="Password"/>
                    <div class="has-error">
                        <p class="text-danger">{{ e($errors->first('password')) }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection