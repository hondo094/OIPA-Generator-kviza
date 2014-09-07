<?php

Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@home'
    ));

Route::controller('password', 'RemindersController');

Route::get('/kviz/{quizzName}', array(
    'as' => 'quizz-display',
    'uses' => 'QuizzController@display'
    ));

Route::post('/kviz/{quizzName}', array(
    'as' => 'quizz-display-post',
    'uses' => 'QuizzController@evaluate'
    ));

/*
|  Authenticated group
*/
Route::group(array('before' => 'auth'), function(){   
    Route::group(array('before' => 'csrf'), function(){
        /*
        |  Profile (POST)
        */
        Route::post('/upload', array(
            'as' => 'upload-post',
            'uses' => 'ProfileController@postUpload'
        ));
        /*
        |  Join group (POST)
        */
        Route::post('/join', array(
            'as' => 'join-post',
            'uses' => 'ProfileController@postJoin'
        ));
        
        /*
        |  Edit quizz (POST)
        */
        Route::post('/uredi/{id}', array(
            'as' => 'quizz-edit-post',
            'uses' => 'QuizzController@postEditQuizz'
        ));
        
    });
  

    /*
    |  Sign out (GET)
    */
    Route::get('/account/sign-out', array(
        'as' => 'account-sign-out',
        'uses' => 'AccountController@getSignOut'
    ));

    /*
    |  Profile (GET)
    */
    Route::get('/user/{username}', array( 
        'as' => 'profile-user',
        'uses' => 'ProfileController@user'
    ));
    
    /*
    |  Edit quizz (GET)
    */
    Route::get('/uredi/{id}', array(
        'as' => 'quizz-edit',
        'uses' => 'QuizzController@editQuizz'
    ));
    
    /*
    |  Delete quizz (GET)
    */
    Route::get('/obrisi/{id}', array(
        'as' => 'quizz-delete',
        'uses' => 'QuizzController@deleteQuizz'
    ));
    

});


/*
|  Unauthenticated group
 */
Route::group(array('before' => 'guest'), function(){
    
    /*
    | CSRF protection group
    */
    Route::group(array('before' => 'csrf'), function(){
        /*
        | Create account (POST)
        */   
        Route::post('/account/create', array(
        'as' => 'account-create-post',
        'uses' => 'AccountController@postCreate'
        ));   
        
        /*
        | Sign in (POST)
        */ 
        Route::post('/account/sign-in', array(
        'as' => 'account-sign-in-post',
        'uses' => 'AccountController@postSignIn'
        ));
        
    });
    
    /*
    | Sign in (GET)
    */ 
    Route::get('/account/sign-in', array(
    'as' => 'account-sign-in',
    'uses' => 'AccountController@getSignIn'
    ));
    
    /*
    | Create account (GET)
    */   
    Route::get('/account/create', array(
    'as' => 'account-create',
    'uses' => 'AccountController@getCreate'
    ));    
    
});

    
// ===============================================
// 404 ===========================================
// ===============================================

App::error(function($exception, $code)
{
    switch ($code)
    {
        case 403:
            return Response::view('errors.403', array(), 403);

        case 404:
            return Response::view('errors.404', array(), 404);

        case 500:
            return Response::view('errors.403', array(), 500);

        default:
            return Response::view('errors.default', array(), $code);
    }
});