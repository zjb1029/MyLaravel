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

/**
 * 首页/帮助/关于/登录/激活
 */
Route::get('/',"StaticPagesController@home")->name('home');
Route::get('/help',"StaticPagesController@help")->name('help');
Route::get('/about',"StaticPagesController@about")->name('about');
Route::get('/signup',"UsersController@create")->name('signup');
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');


/**
 * 用户相关
 */
Route::resource('users', 'UsersController');

/**
 * 上面一句等价于下面的
 */
//Route::get('/users', 'UsersController@index')->name('users.index');用户列表
//Route::get('/users/create', 'UsersController@create')->name('users.create');用户注册
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');//用户查看
//Route::post('/users', 'UsersController@store')->name('users.store');//用户新增
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');//用户编辑页
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');//用户修改
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');//用户删除

/**
 * 登录/登出
 */
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');


/**
 * 找回密码
 */
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');//重置密码页面
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');//发送邮件
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');//更新密码页面
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');//更新密码提交