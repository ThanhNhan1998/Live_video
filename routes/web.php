<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

// Route::get('/{any}', 'RoomController@home')->where('any', '.*');
//Route::get('/{any?}', 'RoomController@home')->where('any', '.*');

Route::get('/', function () {
    return view('welcome');
});

$router->get('/{catch?}', function () { 
    return view('spa'); 
})->where('catch', '^(?!phonghop).*$');

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/phonghop/currentUser', 'RoomController@currentUser');
    
    Route::get('/phonghop/{id}/userNotInRoom', 'RoomController@userNotInRoom');

    Route::get('/phonghop', 'RoomController@index');

    Route::post('/phonghop/create', 'RoomController@create');

    Route::post('/phonghop/{id}/edit', 'RoomController@edit');

    Route::put('/phonghop/{id}', 'RoomController@destroy');

    Route::get('/phonghop/{id}', 'RoomController@show');

    Route::post('/phonghop/{id}/invite/', 'RoomController@invite');

    Route::get('/phonghop/{id}/remove/{user_id}', 'RoomController@removeUser');

    Route::get('/phonghop/videoChat', 'VideoChatController@infoCall');

    Route::post('/phonghop/auth/video_chat', 'VideoChatController@auth');
});
