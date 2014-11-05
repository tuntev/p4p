<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getLogin(){
        return View::make('login');
    }

    public function postLogin() {
        $validator = Validator::make(Input::all(), array(
            'username'=>'required|min:5',
            'password'=>'required|min:3'
        ));
        if($validator->fails()){

            return Redirect::route('login')
                ->withErrors($validator)
                ->withInput();

        }
        else {
            $remember = Input::has('remember') ? true : false;

            //echo '<pre>';print_r(Hash::make(Input::get('password')));die;

            $auth = Auth::attempt(array(
                'username'=>Input::get('username'),
                'password'=>Input::get('password')
            ), $remember);

            if($auth){
                //return Redirect::route('offers');
                return Redirect::intended('/');
//                return Redirect::route('main');
            } else {
                return Redirect::route('login')
                    ->with('global','Погрешно корисничко име или лозинка');
            }

        }
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::route('login');
    }

    public function getMain(){
        return View::make('main.index');
    }

}
