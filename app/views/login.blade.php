@extends('partials.default')
@section('title')Private system
@stop
@section('content')
@include('partials.companyInfo')
@include('partials.errorMsg')
@include('partials.infoMsg')
<div class="loginForm">
    <form action="{{ URL::route('login-post') }}" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="inputUser" class="col-sm-offset-2 col-sm-3 control-label">Username</label>
            <div class="col-sm-3">
                <input type="text" name="username" class="form-control" id="inputUser" placeholder="Username">
            </div>
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-sm-offset-2 col-sm-3 control-label">Password</label>
            <div class="col-sm-3">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            @if($errors->has('password'))
            {{ $errors->first('password') }}
            @endif
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-10">
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
        </div>
        {{ Form::token() }}
    </form>
    <div class="row">
        <div class="col-lg-6 text-right">
            <a href="{{ URL::action('account-create') }}">Create an account</a>
        </div>
        <div class="col-lg-6">
            <a href="{{ URL::action('account-forgot') }}">Forgot password</a>
        </div>
    </div>
</div>
@stop

