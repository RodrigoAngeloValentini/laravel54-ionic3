<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin','as' => 'admin.','namespace' => 'Admin\\'], function (){

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['isVerified','can:admin']], function (){
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('dashboard', function (){
            return view('admin.dashboard');
        })->name('dashboard');
        Route::get('users/settings','Auth\UserSettingsController@edit')->name('user_settings.edit');
        Route::put('users/settings','Auth\UserSettingsController@update')->name('user_settings.update');
        Route::resource('users', 'UserController');
        Route::get('/change/password', 'UserController@showPasswordForm')->name('change.password');
        Route::put('update/password/{id}', 'UserController@updatePassword')->name('update.password');
        Route::resource('categories', 'CategoryController');
        Route::resource('plans', 'PlansController');
        Route::resource('web_profiles', 'PayPalWebProfilesController');

        Route::get('series/{serie}/thumb_asset', 'SeriesController@thumbAsset')->name('series.thumb_asset');
        Route::get('series/{serie}/thumb_small_asset', 'SeriesController@thumbSmallAsset')->name('series.thumb_small_asset');
        Route::resource('series', 'SeriesController');

        Route::group(['prefix' => 'videos', 'as' => 'videos.'], function (){
            Route::get('{video}/relations', 'VideoRelationsController@create')->name('relations.create');
            Route::post('{video}/relations', 'VideoRelationsController@store')->name('relations.store');
            Route::get('{video}/uploads','VideoUploadsController@create')->name('uploads.create');
            Route::post('{video}/uploads','VideoUploadsController@store')->name('uploads.store');
        });
    });
    Route::get('videos/{video}/thumb_asset', 'VideoController@thumbAsset')->name('videos.thumb_asset');
    Route::get('videos/{video}/thumb_small_asset', 'VideoController@thumbSmallAsset')->name('videos.thumb_small_asset');
    Route::get('videos/{video}/file_asset', 'VideoController@fileAsset')->name('videos.file_asset');
    Route::resource('videos', 'VideoController');
});

Route::get('/force-login', function (){
   \Auth::loginUsingId(1);
});