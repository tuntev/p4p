<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 10/30/14
 * Time: 5:00 PM
 */

class UsersController extends BaseController {

    public function getUsers() {
        $users = User::orderBy('id', 'asc')->paginate(5);

        return View::make('users.users')->with('users',$users);
    }

    public function getCreate(){

        return View::make('users.create');

    }

    public function getRecovery(){

        return View::make('users.forgot');

    }

    public function getEdit(){

        return View::make('users.edit');

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
