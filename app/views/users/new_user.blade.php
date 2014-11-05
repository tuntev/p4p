@extends('templates.default')
@section('title'){{ ($action == 'new') ? 'Нов корисник' : 'Промена на корисник' }}
@stop
@section('content')
@include('templates.navigation')
<div class="">
    <form method="post" class="form-horizontal" role="form"
          action="{{ ($action === 'new') ? URL::route('new-user-post') :  URL::route('edit-user-post', $user->id)}}">
        <div class="form-group">
            <label for="inputFirst" class="col-sm-offset-2 col-sm-3 control-label">Име</label>
            <div class="col-sm-3">
                <input type="text" name="firstName" class="form-control" id="inputFirst" placeholder="Име"
                @if($action == 'new')
                {{ Input::old('firstName') ? ' value="' . e(input::old('firstName')) . '"' : '' }}
                @else
                {{ $user->firstName ? ' value="' . e($user->firstName) . '"' : '' }}
                @endif

                >
            </div>
            @if($errors->has('firstName'))
            {{ $errors->first('firstName') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputLast" class="col-sm-offset-2 col-sm-3 control-label">Презиме</label>
            <div class="col-sm-3">
                <input type="text" name="lastName" class="form-control" id="inputLast" placeholder="Презиме"
                @if($action == 'new')
                {{ Input::old('lastName') ? ' value="' . e(input::old('lastName')) . '"' : '' }}
                @else
                {{ $user->lastName ? ' value="' . e($user->lastName) . '"' : '' }}
                @endif
                >
            </div>
            @if($errors->has('lastName'))
            {{ $errors->first('lastName') }}
            @endif
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-offset-2 col-sm-3 control-label">e-Mail</label>
            <div class="col-sm-3">
                <input type="text" name="email" class="form-control" id="email" placeholder="e-Mail"
                @if($action == 'new')
                {{ Input::old('email') ? ' value="' . e(input::old('email')) . '"' : '' }}
                @else
                {{ $user->email ? ' value="' . e($user->email) . '"' : '' }}
                @endif
                >
            </div>
            @if($errors->has('email'))
            {{ $errors->first('email') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputUser" class="col-sm-offset-2 col-sm-3 control-label">Корисничко име</label>
            <div class="col-sm-3">
                <input type="text" name="username" class="form-control" id="inputUser" placeholder="Корисничко име"
                @if($action == 'new')
                {{ Input::old('username') ? ' value="' . e(input::old('username')) . '"' : '' }}
                @else
                {{ $user->username ? ' value="' . e($user->username) . '"' : '' }}
                @endif
                >
            </div>
            @if($errors->has('username'))
            {{ $errors->first('username') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputPassword" class="col-sm-offset-2 col-sm-3 control-label">Лозинка</label>
            <div class="col-sm-3">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Лозинка">
            </div>
            @if($errors->has('password'))
            {{ $errors->first('password') }}
            @endif
        </div>
        <div class="form-group">
            <label for="inputPasswordAgain" class="col-sm-offset-2 col-sm-3 control-label">Лоаинка повторно</label>
            <div class="col-sm-3">
                <input type="password" name="password_again" class="form-control" id="inputPasswordAgain" placeholder="Лозинка повторно">
            </div>
            @if($errors->has('password_again'))
            {{ $errors->first('password_again') }}
            @endif
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="admin"
                            {{ (isset($user->admin) && $user->admin == 1) ? 'checked' : '' }}
                            > Администратор
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-6">
                <a class="btn btn-default" href="{{ URL::route('users') }}">Назад</a>&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">Зачувај</button>
            </div>
        </div>
        {{ Form::token() }}
    </form>
</div>
@stop

