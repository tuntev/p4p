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

    Route::get('/user/create', array(
        'as'=>'account-create',
        'uses'=>'UsersController@getCreate'
    ));

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

    Route::group(['before' => 'admin'], function(){

        Route::get('/users', array(
            'as'=>'users',
            'uses'=>'UsersController@getUsers'
        ));

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

        // change done
        Route::put('/todos/update/{id}', array(
            'uses'=>'TodosController@update'
        ));

        // DELETE todo
        Route::delete('/todos/delete/{id}', array(
            'uses'=>'TodosController@getDeleteTodo'
        ));

        // PROJECTS:
        Route::get('/prog4', array(
            'as'=>'prog4',
            'uses'=>'Prog4Controller@index'
        ));
        // get projects

        Route::group(['prefix' => 'p4projects'], function(){

            Route::get('/', array(
                'uses'=>'Prog4Controller@getProjects'
            ));

            Route::get('/{id}', array(
                'uses'=>'Prog4Controller@getProjectById'
            ));


            Route::put('/update/{id}', array(
                'uses'=>'Prog4Controller@updateDone'
            ));

            // DELETE project
            Route::delete('/delete/{id}', array(
                'uses'=>'Prog4Controller@getDeleteProject'
            ));

        });



        // change DONE



        // COURSES
        Route::get('/courses', array(
            'as'=>'courses',
            'uses'=>'CoursesController@index'
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