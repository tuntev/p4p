@extends('partials.default')
@section('title')Password recovery
@stop
@section('content')
@include('partials.companyInfo')
<form action="{{ URL::route('account-forgot-post') }}" method="post" class="form-horizontal" role="form">
    <div class="form-group">
        <label for="email" class="col-sm-offset-2 col-sm-3 control-label">E-mail</label>
        <div class="col-sm-3">
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter your email address">
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


