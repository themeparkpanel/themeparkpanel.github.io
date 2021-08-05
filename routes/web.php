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

//AUTH
use Illuminate\Support\Facades\DB;

Auth::routes([
    'verify' => true,
    'register' => true
]);

Route::namespace('Panel')->prefix('panel')->group(function () {
    //Dashboard
    Route::get('/home', 'HomeController@index')->name('panel.home');

    //UMS
    Route::prefix('ums')->group(function () {
        Route::get('/{page?}/{search?}', 'UMSController@index')->where('page', '[0-9]+')->name('panel.ums');
        Route::get('/info/{id}', 'UMSController@info')->where('id', '[0-9]+')->name('panel.ums.info');
        Route::get('/edit/{id}', 'UMSController@edit')->where('id', '[0-9]+')->name('panel.ums.edit');
        Route::post('/update', 'UMSController@update')->name('panel.ums.update');
        Route::get('/delete/{id}', 'UMSController@delete')->where('id', '[0-9]+')->name('panel.ums.delete');
    });

    //Dashboard
    Route::get('/message', 'MessageController@index')->name('panel.message');
    Route::post('/message', 'MessageController@change');

    //Shows
    if(env('SHOWS', false)) {
        Route::prefix('show')->group(function () {
            Route::get('/{page?}/{search?}', 'ShowController@index')->where('page', '[0-9]+')->name('panel.show');
            Route::get('/add', 'ShowController@add')->name('panel.show.add');
            Route::post('/create', 'ShowController@create')->name('panel.show.create');
            Route::get('/info/{id}', 'ShowController@info')->where('id', '[0-9]+')->name('panel.show.info');
            Route::get('/edit/{id}', 'ShowController@edit')->where('id', '[0-9]+')->name('panel.show.edit');
            Route::post('/update', 'ShowController@update')->name('panel.show.update');
            Route::get('/delete/{id}', 'ShowController@delete')->where('id', '[0-9]+')->name('panel.show.delete');
        });

        Route::prefix('shows')->group(function () {
            Route::get('/{page?}/{search?}', 'ShowsController@index')->where('page', '[0-9]+')->name('panel.shows');
            Route::get('/add', 'ShowsController@add')->name('panel.shows.add');
            Route::post('/search', 'ShowsController@search')->name('panel.shows.search');
            Route::post('/create', 'ShowsController@create')->name('panel.shows.create');
            Route::get('/info/{id}', 'ShowsController@info')->where('id', '[0-9]+')->name('panel.shows.info');
            Route::get('/delete/{id}', 'ShowsController@delete')->where('id', '[0-9]+')->name('panel.shows.delete');
        });
    }

    //Tools
    Route::prefix('tools')->group(function () {
        Route::get('/operator', 'ToolController@operator')->name('panel.operator');

        //Css
        Route::prefix('css')->group(function () {
            Route::get('/', 'ToolController@css')->name('panel.css');
            Route::post('/', 'ToolController@cssPost');
            Route::get('/reset', 'ToolController@cssReset')->name('panel.css.reset');
        });

    });
});

//Home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

//Status and Ridecount
Route::get('/status', 'HomeController@status')->name('status');
Route::get('/ridecount/{attraction_id}', 'RidecountController@index')->name('ridecount');

//Shows
if(env('SHOWS', false)) {
    Route::get('/shows', 'ShowController@index')->name('shows');
    Route::get('/order/{show_id}', 'ShowController@order')->name('order');
    Route::post('/order/make', 'ShowController@makeOrder')->name('makeOrder');
}

//Store
if(!empty(env('STORE_URL', '')))
    Route::get('/store', 'HomeController@store')->name('store');


if(DB::getSchemaBuilder()->hasTable('actionfotos'))
    Route::get('/photo', 'HomeController@photo')->name('photo');

//OpenAudioMc
if(!empty(env('OPENAUDIOMC_URL', '')))
    Route::get('/openaudiomc', 'OpenAudioMCController@index')->name('openaudiomc');

//Logout Route
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

//2FA Authentication
Route::prefix('2fa')->group(function () {
    Route::get('/authenticate', 'TwoFactorController@index')->name('2fa.authenticate');
    Route::post('/authenticate', 'TwoFactorController@authenticate');
    Route::post('/toggle', 'ToggleTwoFactorController@toggle')->name('2fa.toggle');
});

//Profile
Route::namespace('Profile')->prefix('profile')->group(function() {
    //User Profile/Security
    Route::get('/home', 'HomeController@index')->name('profile.home');
    Route::get('/security/{page?}', 'SecurityController@index')->where('page', '^[1-9]\d*$')->name('security');
    Route::get('/session/{id}', 'SecurityController@session')->name('session.delete');

    //Change
    Route::prefix('change')->group(function () {
        Route::get('/', 'ChangeController@index')->name('change');
        Route::post('/password', 'ChangeController@changePassword')->name('change.password');
        Route::post('/email', 'ChangeController@changeEmail')->name('change.email');
        Route::get('/email/{id}/{token}/{email}', 'ChangeController@verifyEmail')->name('verify_email');
    });
});
