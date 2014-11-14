<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = User::orderBy('id', 'asc')->paginate(5);

        return View::make('users.users')->with('users',$users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make(Input::all(),
            array(
                'email'             =>'required|email|unique:users',
                'username'          =>'required|max:20|min:5|unique:users',
                'password'          =>'required|min:6',
                'password_c'        =>'required|same:password'
            )
        );

        if($validator->fails()){
            return Redirect::route('account-create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $email = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');
            $access = Input::get('access') ? Input::get('access') : 2;

            $user = User::create(array(
                'email'=>$email,
                'username'=>$username,
                'password'=>Hash::make($password),
                'access'=>$access,
                'type'=>'system'
            ));

            if($user){

                if(Auth::check()){
                    return Redirect::route('users')
                        ->with('success','User created');
                }

                return Redirect::route('login')
                    ->with('success','Your account has been created. You can log in now.');

            }else{
                return Redirect::route('login')
                    ->with('global','Error while creating the account');

            }
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::find($id);
        if($user && $user->id == Auth::user()->id){
            return View::make('users.show');
        }
        else{
            return Redirect::route('main')
                ->with('global','Забранет пристап.');
        }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('users.edit');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $user = User::where('id',$id)->first();

        if(empty($user)){
            return Redirect::route('users')
                ->with('global','Бараниот корисник не постои.');
        }

        if(Auth::user()->access < 5){
            return Redirect::route('main')
                ->with('global','Немате привилегии за бараната страна.');
        }

        $user->delete();
        return Redirect::back()
            ->with('success','Корисникот е избришан.');
	}

    public function getRecovery(){

        return View::make('users.forgot');

    }

    public function postForgotPassword() {

        $validator = Validator::make(Input::all(), array(
            'email'=>'required|email'
        ));

        if($validator->fails()){
            return Redirect::route('account-forgot')
                ->withErrors($validator)
                ->withInput();
        } else {

            // recover password
            $user = User::where('email','=',Input::get('email'));

            if($user->count()){

                $user = $user->first();
                // generate new code and password

                $code = str_random(60);
                $password = str_random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if($user->save()){

                    Mail::send('emails.auth.forgot',
                        array('link'=> URL::route('account-recover', $code),'username'=>$user->username, 'password'=>$password),
                        function($message) use ($user) {
                            $message->to($user->email, $user->username)->subject('Your new password');
                        });

                    return Redirect::route('login')
                        ->with('success','We have sent you a new password by email.');

                } else {
                    // error
                }

            }

        }

        return Redirect::route('account-forgot-password')
            ->with('global','Could not request new password');
    }

    public function getRecover($code) {
        // Replace password with password temp where $code = code

        $user = User::where('code','=',$code);

        if($user->count()){
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if($user->save()){
                return Redirect::route('login')
                    ->with('success','Your account has been recovered. You can sign in with your new password');
            } else {
                return Redirect::route('login')
                    ->with('global','Problem with saving new password');
            }
        }

        return Redirect::route('login')
            ->with('global','Problem with recovery of password');
    }


}
