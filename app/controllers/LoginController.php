<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 11/7/14
 * Time: 1:52 PM
 */

class LoginController extends BaseController {

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
                $user->username = $me['id'];
                $user->firstName = $me['first_name'];
                $user->lastName = $me['last_name'];
                $user->email = $me['email'];
                $user->link = $me['link'];
                $user->access = 2;
                $user->type = 'fb';
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

            return Redirect::to('main')->with('success', 'Logged in with Facebook');

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

    public function loginWithGoogle() {

        $code = Input::get( 'code' );

        $googleService = OAuth::consumer( 'Google' );

        if ( !empty( $code ) ) {

            $token = $googleService->requestAccessToken( $code );

            $me = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            $profile = Profile::whereUid($me['id'])->first();

            if (empty($profile)) {

                $user = new User;
                $user->username = $me['id'];
                $user->firstName = $me['given_name'];
                $user->lastName = $me['family_name'];
                $user->email = $me['email'];
                $user->link = $me['link'];
                $user->access = 2;
                $user->type = 'google';
                $user->photo = $me['picture'];

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

            return Redirect::to('main')->with('success', 'Logged in with Google');

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }
}