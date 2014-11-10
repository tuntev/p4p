<?php

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
    'uses'=>'FacebookController@loginWithFacebook'
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

    // Create new user GET
    Route::get('/user/create', array(
        'as'=>'account-create',
        'uses'=>'UsersController@getCreate'
    ));

    // Create new user POST
    Route::post('/user/create', array(
        'as'=>'account-create-post',
        'uses'=>'UsersController@postCreate'
    ))->before('csrf');

    // Recover password GET
    Route::get('/user/forgot', array(
        'as'=>'account-forgot',
        'uses'=>'UsersController@getRecovery'
    ));

    // Recover password POST
    Route::post('/user/forget', array(
        'as'=>'account-forgot-post',
        'uses'=>'UsersController@postForgotPassword'
    ))->before('csrf');

    // Recover password (GET)
    Route::get('/user/recover/{code}', array(
        'as'=>'account-recover',
        'uses'=>'UsersController@getRecover'
    ));

});

// Authenticated group

Route::group(array('before'=>'auth'), function(){

    Route::group(array('before'=>'csrf'), function(){

        // all csrf in authenticated group

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
    Route::get('/editUser', array(
        'as'=>'account-edit',
        'uses'=>'UsersController@getEdit'
    ));

    // access level 5 (admin)

    Route::group(['before' => 'staff'], function(){

        Route::get('/user/createNew', array(
            'as'=>'account-create-new',
            'uses'=>'UsersController@getCreate'
        ));

        // TODOS:
        Route::get('/todo', array(
            'as'=>'todo',
            'uses'=>'TodosController@index'
        ));

        // get the data from the DB and send it to the angular view
        Route::get('/todos', function(){
            return Todo::all();
        });

        Route::group(['prefix' => 'p4projects'], function(){

            // get projects
            Route::get('/', array(
                'uses'=>'Prog4Controller@getProjects'
            ));

            // get project by ID
            Route::get('/{id}', array(
                'uses'=>'Prog4Controller@getProjectById'
            ));

        });
        // PROJECTS:
        Route::get('/prog4', array(
            'as'=>'prog4',
            'uses'=>'Prog4Controller@index'
        ));


    });

    Route::group(['before' => 'admin'], function(){

        Route::group(['before' => 'csrf'], function(){

            // POST new user for admin
            Route::post('/user/createAuth', array(
                'as'=>'account-create-post-auth',
                'uses'=>'UsersController@postCreate'
            ));

        });
        // get all users
        Route::get('/users', array(
            'as'=>'users',
            'uses'=>'UsersController@getUsers'
        ));

        // delete user
        Route::get('/user/delete/{id}', array(
            'as'=>'delete-user',
            'uses'=>'UsersController@getDelete'
        ));

        // change done
        Route::put('/todos/update/{id}', array(
            'uses'=>'TodosController@update'
        ));

        // DELETE todo
        Route::delete('/todos/delete/{id}', array(
            'uses'=>'TodosController@getDeleteTodo'
        ));

        // change DONE
        Route::put('p4projects/update/{id}', array(
            'uses'=>'Prog4Controller@updateDone'
        ));

        // DELETE project
        Route::delete('p4projects/delete/{id}', array(
            'uses'=>'Prog4Controller@getDeleteProject'
        ));

    });



    // AJAX requests with csrf token
    Route::group(['before' => 'csrf_json'], function(){

        // insert new todo
        Route::post('/todos', function(){
            return Todo::create(array(
                'text'=>Input::get('text'),
                'done'=>Input::get('done')
            ));
        });

        // insert new P4Project
        Route::post('/p4projects', array(
            'uses'=>'Prog4Controller@postAddNew'
        ));
    });

});