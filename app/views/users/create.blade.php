@extends('partials.default')
@section('title')Create new user
@stop
@section('content')
@if(Auth::check())
@include('partials.navigation')
@else
@include('partials.companyInfo')
@endif
<div ng-app="createAccount">
    <div class="col-xs-offset-1">
        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>
            Back</a>
    </div>
    <form class="form-horizontal" role="form"  name="myForm" method="post"
          action="<?php echo Auth::check() ? URL::action('account-create-post-auth') : URL::action('account-create-post') ?>">

        <div class="form-group">
            <label for="email" class="col-xs-offset-3 col-xs-2 control-label">Email</label>
            <div class="col-xs-3">
                <input class="form-control" type="email" id="email" name="email" ng-model="formData.email" required
                {{ (Input::old('email') ? ' value="' . e(Input::old('email')) . '"' : '') }}/>
                @if($errors->has('email'))
                {{ $errors->first('email') }}
                @endif
            </div>
            <div class="col-xs-3 text-danger">
                <span ng-show="myForm.email.$error.required && myForm.email.$dirty">required</span>
                <span ng-show="!myForm.email.$error.required && myForm.email.$error.email && myForm.email.$dirty">invalid email</span>
            </div>
        </div>
        {{--<div class="form-group">
            <label for="name" class="col-xs-offset-3 col-xs-2 control-label">Name</label>
            <div class="col-xs-3">
                <input class="form-control" type="text" id="name" name="name" ng-model="formData.name" required/>

            </div>
            <div class="col-xs-3 text-danger">
                <span ng-show="myForm.name.$error.required && myForm.name.$dirty">required</span>
            </div>
        </div>--}}
        <div class="form-group">
            <label for="username" class="col-xs-offset-3 col-xs-2 control-label">Username</label>
            <div class="col-xs-3">
                <input class="form-control" type="text" id="username" name="username" ng-model="formData.username" ng-minlength="5" ng-maxlength="20" ng-pattern="/^[A-z][A-z0-9]*$/" required
                {{ (Input::old('username') ? ' value="' . e(Input::old('username')) . '"' : '') }}/>
                @if($errors->has('username'))
                {{ $errors->first('username') }}
                @endif
            </div>
            <div class="col-xs-3 text-danger">
                <span ng-show="myForm.username.$error.required && myForm.username.$dirty">required</span>
                <span ng-show="!myForm.username.$error.minLength && !myForm.username.$error.maxLength && myForm.username.$error.pattern && myForm.username.$dirty">Must start with a letter, and contain letters &amp; numbers only.</span>
                <span ng-show="!myForm.username.$error.required && (myForm.username.$error.minlength || myForm.username.$error.maxlength) && myForm.username.$dirty">Username ust be between 5 and 20 characters.</span>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-xs-offset-3 col-xs-2 control-label">Password</label>
            <div class="col-xs-3">
                <input class="form-control" type="password" id="password" name="password" ng-model="formData.password" ng-minlength="6" ng-maxlength="20" ng-pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])/" required  />
                @if($errors->has('password'))
                {{ $errors->first('password') }}
                @endif
            </div>
            <div class="col-xs-3 text-danger">
                <span ng-show="myForm.password.$error.required && myForm.password.$dirty">required</span>
                <span ng-show="!myForm.password.$error.required && (myForm.password.$error.minlength || myForm.password.$error.maxlength) && myForm.password.$dirty">Passwords must be between 8 and 20 characters.</span>
                <span ng-show="!myForm.password.$error.required && !myForm.password.$error.minlength && !myForm.password.$error.maxlength && myForm.password.$error.pattern && myForm.password.$dirty">Must contain one lower &amp; uppercase letter, and one non-alpha character (a number or a symbol.)</span>
            </div>
        </div>
        <div class="form-group">
            <label for="password_c" class="col-xs-offset-3 col-xs-2 control-label">Confirm Password</label>
            <div class="col-xs-3">
                <input class="form-control" type="password" id="password_c" name="password_c" ng-model="formData.password_c" valid-password-c required  />
                @if($errors->has('password_c'))
                {{ $errors->first('password_c') }}
                @endif
            </div>
            <div class="col-xs-3 text-danger">
                <span ng-show="myForm.password_c.$error.required && myForm.password_c.$dirty">Please confirm your password.</span>
                <span ng-show="!myForm.password_c.$error.required && myForm.password_c.$error.noMatch && myForm.password.$dirty">Passwords do not match.</span>
            </div>
        </div>
        @if(Auth::check())
        <div class="form-group">
            <label for="access" class="col-xs-offset-3 col-xs-2 control-label">Access</label>
            <div class="col-xs-3">
                <select name="access" id="access" class="form-control">
                    <option value="1">Access level 1</option>
                    <option value="2">Access level 2</option>
                    <option value="5">Access level 5</option>
                </select>
            </div>
        </div>
        @endif
        <div class="form-group">
            <div class="col-xs-offset-5 col-xs-2">
                <button type="submit" class="btn btn-primary" ng-disabled="!myForm.$valid">Create</button>
            </div>
        </div>
        {{ Form::token() }}
    </form>

</div>

@stop


