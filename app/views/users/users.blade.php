@extends('partials.default')
@section('title')Users
@stop
@section('content')
@include('partials.navigation')

<div id="users" class="text-center">
    <div class="row">
        <div class="col-md-offset-3 col-md-6 text-center">
            <h2>All users</h2>
        </div>
        <div class="col-md-3 text-left">
            <h2><a class="btn btn-primary" href="{{ URL::route('account-create-new') }}">Add new user</a></h2>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="text-center" style="width: 20%">Name</th>
            <th class="text-center" style="width: 20%">Last Name</th>
            <th class="text-center" style="width: 15%">Username</th>
            <th class="text-center" style="width: 20%">e-mail</th>
            <th class="text-center" style="width: 10%">Access</th>
            <th class="text-center" style="width: 10%" colspan="2" class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ e($user->firstName) }}</td>
            <td>{{ e($user->lastName) }}</td>
            <td>{{ e($user->username) }}</td>
            <td>{{ e($user->email) }}</td>
            <td>{{ e($user->access) }}</td>
            <td><a href="" class="glyphicon glyphicon-pencil"></a></td>
            <td><a href="" class="jsDelete glyphicon glyphicon-trash"></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@stop