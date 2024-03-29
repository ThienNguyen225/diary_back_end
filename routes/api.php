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


Route::post('login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback', 'SocialController@Callback');

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::prefix('admin')->group(function () {
        //lấy 1 user đang đang nhập
        Route::get('user', 'AuthController@user');
        //update user đang đang nhập
        Route::put('user', 'AuthController@updateUser');
        //thêm mới 1 tài khoản
        Route::post('user', 'UserApiController@store');
        //reset password user đang đăng nhập
        Route::put('reset/user', 'AuthController@changePassword');
        //lấy danh sách tất cả tài khoản
        Route::get('users', 'UserApiController@index');
        //cập nhật 1 tài khoản
        Route::put('user/{id}', 'UserApiController@update');
        // xóa 1 tài khoản
        Route::delete('user/{id}', 'UserApiController@destroy');
        //lấy tài khoản theo ID
        Route::get('user/{id}', 'UserApiController@show');

        //lấy tất cả các bài nhật ký
        Route::get('diary', 'DiaryApiController@index');
    });

    Route::prefix('user')->group(function () {
        //lấy tất cả nhật ký của tài khoản đang đăng nhập
        Route::get('diary', 'DiaryApiController@getDiaryOfUser');
        //thêm mới nhật ký của tài khoản đang đăng nhập
        Route::post('diary', 'DiaryApiController@store');
        //chỉnh sửa nhật ký của tài khoản đang đăng nhập
        Route::put('diary/{id}', 'DiaryApiController@update');
        //xóa nhật ký của tài khoản đang đăng nhập
        Route::delete('diary/{id}', 'DiaryApiController@destroy');
        //lấy 1 nhật ký của tài khoản đang đăng nhập theo id
        Route::get('diary/{id}', 'DiaryApiController@show');
    });

    Route::post('logout', 'AuthController@logout');
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');
