@extends('partials.default')
@section('title')Programming 4
@stop
@section('content')
@include('partials.navigation')
<div class="row" ng-app="app">
    <ul class="nav nav-tabs" role="tablist" id="tabs">
        <li id="ng-tab1" role="presentation" class="active"><a href="#/home">Home</a></li>
        <li id="ng-tab2" role="presentation"><a href="#/projects">Projects</a></li>
        <li id="ng-tab3" role="presentation"><a href="#/todo">Todos</a></li>
        <li id="ng-tab4" role="presentation"><a href="#/demo">Demo</a></li>
    </ul>
    <br/>
    <div ng-view class="theSPA"></div>
</div>
@stop


