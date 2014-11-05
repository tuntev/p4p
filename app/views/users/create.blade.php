@extends('partials.default')
@section('title')Create new user
@stop
@section('content')
@if(Auth::check())
@include('partials.navigation')
@else
@include('partials.companyInfo')
@endif
<h3>Create account form</h3>
@stop


