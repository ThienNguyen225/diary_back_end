<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('signup', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::prefix('admin')->group(function () {
        //lấy 1 user đang đang nhập
        Route::get('user', 'AuthController@user');
        //lấy danh sách tất cả tài khoản
        Route::get('users', 'UserApiController@index');
        //thêm mới 1 tài khoản
        Route::post('user', 'UserApiController@store');
        //cập nhật 1 tài khoản
        Route::put('user/{id}', 'UserApiController@update');
        // xóa 1 tài khoản
        Route::delete('user/{id}', 'UserApiController@destroy');
        //lấy tài khoản theo ID
        Route::get('user/{id}', 'UserApiController@show');
    });
    Route::post('logout', 'AuthController@logout');
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');
