<?php

// REST P4P - test - without user access
//Route::group(['prefix' => 'api'], function(){
//
//    Route::resource('p4p', 'P4PController');
//
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// facebook login
Route::get('login/fb', array(
    'as'=>'login-fb',
    'uses'=>'LoginController@loginWithFacebook'
));

Route::get('login/google', array(
    'as'=>'login-google',
    'uses'=>'LoginController@loginWithGoogle'
));

// Unathenticated group

Route::group(array('before'=>'guest'), function(){

    Route::get('/', array(
        'as'=>'login',
        'uses'=>'HomeController@getLogin'
    ));

    // GET login
    Route::get('/login', array(
        'as'=>'login',
        'uses'=>'HomeController@getLogin'
    ));

    //POST login
    Route::post('/login', array(
        'as'=>'login-post',
        'uses'=>'HomeController@postLogin'
    ))->before('csrf');

    Route::group(['prefix' => 'users'], function(){

        // Create new user GET
        Route::get('/create', array(
            'as'=>'account-create',
            'uses'=>'UserController@create'
        ));

        // Create new user POST
        Route::post('/create', array(
            'as'=>'account-create-post',
            'uses'=>'UserController@store'
        ))->before('csrf');

        // Recover password GET
        Route::get('/forgot', array(
            'as'=>'account-forgot',
            'uses'=>'UserController@getRecovery'
        ));

        // Recover password POST
        Route::post('/forget', array(
            'as'=>'account-forgot-post',
            'uses'=>'UserController@postForgotPassword'
        ))->before('csrf');

        // Recover password (GET)
        Route::get('/recover/{code}', array(
            'as'=>'account-recover',
            'uses'=>'UserController@getRecover'
        ));

    });


});

// Authenticated group

Route::group(array('before'=>'auth'), function(){

    Route::group(array('before'=>'csrf'), function(){

        // all csrf in authenticated group

    });

    // AJAX requests with csrf token
    Route::group(['before' => 'csrf_json'], function(){



    });

    // DEFAULT landing page

    Route::get('/main', array(
        'as'=>'main',
        'uses'=>'HomeController@getMain'
    ));

    // Sign Out (GET)

    Route::get('/logout', array(
        'as'=>'logout',
        'uses'=>'HomeController@getLogout'
    ));

    // Edit Account
    Route::get('/users/{id}', array(
        'as'=>'account-edit',
        'uses'=>'UserController@show'
    ));

    Route::get('api/users/{id}', array(
        'uses'=>'UserController@getData'
    ));

    // access level 5 (admin)

    Route::group(['before' => 'staff'], function(){

        Route::group(['prefix' => 'api'], function(){

            Route::resource('student', 'StudentController');

        });


        Route::group(['prefix' => 'api/p4p'], function(){

            // get projects
            Route::get('/', array(
                'uses'=>'P4PController@index'
            ));

            // get project by ID
            Route::get('/{id}', array(
                'uses'=>'P4PController@show'
            ));

        });

        // TODOS:
        Route::get('/todo', array(
            'as'=>'todo',
            'uses'=>'TodosController@index'
        ));

        // get the data from the DB and send it to the angular view
        Route::get('/todos', function(){
            return Todo::all();
        });


        // PROJECTS:
        Route::get('/prog4', array(
            'as'=>'prog4',
            'uses'=>'P4PController@getP4Pindex'
        ));

    });

    Route::group(['before' => 'admin'], function(){

        Route::group(['before' => 'csrf'], function(){

            // POST new user for admin
            Route::post('/users/createAuth', array(
                'as'=>'account-create-post-auth',
                'uses'=>'UserController@store'
            ));

        });

        Route::group(['prefix' => 'api/p4p'], function(){

            // change DONE
            Route::put('/{id}', array(
                'uses'=>'P4PController@update'
            ));

            // DELETE project
            Route::delete('/{id}', array(
                'uses'=>'P4PController@destroy'
            ));

        });

        Route::get('user/createNew', array(
            'as'=>'account-create-new',
            'uses'=>'UserController@create'
        ));

        Route::group(['prefix' => 'users'], function(){

            // get all users
            Route::get('/', array(
                'as'=>'users',
                'uses'=>'UserController@index'
            ));
            // edit user
            Route::get('/{id}/edit', array(
                'as'=>'edit-user',
                'uses'=>'UserController@edit'
            ));

            // delete user
            Route::get('/delete/{id}', array(
                'as'=>'delete-user',
                'uses'=>'UserController@destroy'
            ));



        });


        // change done
        Route::put('/todos/update/{id}', array(
            'uses'=>'TodosController@update'
        ));

        // DELETE todo
        Route::delete('/todos/delete/{id}', array(
            'uses'=>'TodosController@getDeleteTodo'
        ));

        Route::group(['before' => 'csrf_json'], function(){

            Route::post('/todos', function(){
                return Todo::create(array(
                    'text'=>Input::get('text'),
                    'done'=>Input::get('done')
                ));
            });

            Route::post('api/p4p', array(
                'uses'=>'P4PController@store'
            ));

        });

    });

});

