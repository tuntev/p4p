@extends('partials.default')
@section('title')Password recovery
@stop
@section('content')
@include('partials.companyInfo')
<div class="col-xs-offset-1">
    <a href="{{ URL::previous() }}" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>
        Back</a>
</div>
<form action="{{ URL::route('account-forgot-post') }}" method="post" class="form-horizontal" role="form" ng-app>
    <div class="form-group">
        <label for="email" class="col-sm-offset-2 col-sm-3 control-label">E-mail</label>
        <div class="col-sm-3">
            <input required type="text" name="email" class="form-control" id="email" placeholder="Enter your email address">
        </div>
        @if($errors->has('email'))
        {{ $errors->first('email') }}
        @endif
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-10">
            <button type="submit" class="btn btn-primary">Recover password</button>
        </div>
    </div>
    {{ Form::token() }}
</form>
@stop


