<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 11/7/14
 * Time: 1:52 PM
 */

class FacebookController extends BaseController {

    public function loginWithFacebook() {

        // get data from input
        $code = Input::get( 'code' );
        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $me = json_decode( $fb->request( '/me' ), true );

            $profile = Profile::whereUid($me['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->firstName = $me['first_name'];
                $user->lastName = $me['last_name'];
                $user->email = $me['email'];
                $user->access = 2;
                $user->photo = 'https://graph.facebook.com/'.$me['name'].'/picture?type=large';

                $user->save();

                $profile = new Profile();
                $profile->uid = $me['id'];
                $profile->username = $me['name'];
                $profile = $user->profiles()->save($profile);
            }

//            $profile->access_token = $token;
            $profile->save();

            $user = $profile->user;

            Auth::login($user);

            return Redirect::to('main')->with('message', 'Logged in with Facebook');

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }
}