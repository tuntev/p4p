@extends('partials.default')
@section('title')Private system
@stop
@section('content')
@include('partials.companyInfo')
@include('partials.errorMsg')
@include('partials.infoMsg')
<div class="loginForm" ng-app>
    <form action="{{ URL::route('login-post') }}" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="inputUser" class="col-md-offset-2 col-md-3 control-label">Username</label>
            <div class="col-md-3">
                <input required type="text" name="username" class="form-control" id="inputUser" placeholder="Username">
            </div>
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-md-offset-2 col-md-3 control-label">Password</label>
            <div class="col-md-3">
                <input required type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            @if($errors->has('password'))
            {{ $errors->first('password') }}
            @endif
        </div>
        <div class="form-group">
            <div class="col-md-offset-5 col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-5 col-md-7">
                <button type="submit" class="btn btn-primary">Log in</button>
                <a href="login/fb" class="btn btn-social-icon btn-facebook">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="login/google" class="btn btn-social-icon btn-google-plus">
                    <i class="fa fa-google"></i>
                </a>

            </div>
        </div>
        {{ Form::token() }}
    </form>
    <div class="row text-center">
        <a href="{{ URL::action('account-create') }}">Create an account</a>&nbsp;&nbsp;&nbsp;
        <a href="{{ URL::action('account-forgot') }}">Forgot password</a>
    </div>
</div>
@stop

