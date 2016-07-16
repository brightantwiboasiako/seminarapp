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
    return redirect('seminar-2016');
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

        Route::get('seminar/{slug}/comments', [
            'uses' => 'Api\SeminarController@comments'
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

    Route::get('{slug}/in', [
        'uses' => 'SeminarController@showCheckInScreen'
    ]);

    Route::post('{slug}/in', [
        'uses' => 'SeminarController@processCheckIn'
    ]);

    Route::get('{slug}/checkin', [
        'uses' => 'SeminarController@processCheckIn'
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


            Route::post('edit', [
               'uses' => 'AdminController@editSeminar'
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

            Route::get('{slug}/download', [
                'uses' => 'SeminarController@downloadParticipants'
            ]);

            Route::get('{slug}/download-survey', [
                'uses' => 'SeminarController@downloadSurveyData'
            ]);

            Route::post('{slug}/delete', [
                'uses' => 'SeminarController@delete'
            ]);


            Route::get('{slug}/comments', [
                'uses' => 'AdminController@getCommentsScreen'
            ]);

            Route::get('{slug}/files', [
                'uses' => 'AdminController@getFilesLinkScreen'
            ]);

            Route::post('files-url', [
                'uses' => 'SeminarController@saveFilesUrl'
            ]);


        });


        // Settings
        Route::get('settings', [
           'uses' => 'AdminController@getSettingsScreen'
        ]);

        Route::post('change-password', [
           'uses' => 'AdminController@changePassword'
        ]);


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