<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Api Routes
Route::group(['middleware' => 'api', 'prefix' => 'api'], function(){

    Route::get('seminars', [
       'uses' => 'Api\SeminarController@all'
    ]);

    Route::group(['middleware' => 'auth'], function(){
        Route::get('seminar/{slug}/participants', [
            'uses' => 'Api\SeminarController@participants'
        ]);

        Route::get('seminar/{slug}/survey', [
            'uses' => 'Api\SeminarController@survey'
        ]);
    });

});


Route::group(['middleware' => 'web'], function(){

    Route::get('{slug}', [
        'uses' => 'SeminarController@getSeminarScreen'
    ]);


    Route::get('{slug}/register', [
       'uses' => 'SeminarController@getRegistrationScreen'
    ]);

    Route::get('{slug}/directions', [
        'uses' => 'SeminarController@showDirectionsScreen'
    ]);

    Route::get('{slug}/survey', [
        'uses' => 'SeminarController@showSurveyScreen'
    ]);

    Route::post('{slug}/survey/response', [
        'uses' => 'SeminarController@processSurveyResponse'
    ]);

    Route::post('seminar/register', [
       'uses' => 'SeminarController@register'
    ]);

});


// Admin Routes
Route::group(['prefix' => 'admin'], function(){

    //Authenticated Routes
    Route::group(['middleware' => 'auth'], function(){

        // Seminar Routes
        Route::group(['prefix' => 'seminar'], function(){
            Route::post('create', [
               'uses' => 'AdminController@createSeminar'
            ]);


            Route::get('{slug}', [
                'uses' => 'AdminController@showSeminarScreen'
            ]);

            Route::get('{slug}/participants', [
                'uses' => 'AdminController@getParticipantsScreen'
            ]);

            Route::get('{slug}/survey', [
                'uses' => 'AdminController@getSurveyScreen'
            ]);

        });


        // Dashboard
        Route::get('dashboard', [
           'uses' => 'AdminController@dashboard'
        ]);

        // Logout
        Route::get('logout', [
            'uses' => 'Auth\AuthController@logout'
        ]);

    });


    // Guest Routes
    Route::group(['middleware' => 'guest'], function(){

        Route::get('login', [
            'uses' => 'Auth\AuthController@getLoginScreen'
        ]);

        Route::post('login', [
            'uses' => 'Auth\AuthController@processLogin'
        ]);
    });



});