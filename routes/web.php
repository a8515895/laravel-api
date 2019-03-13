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
Route::get('/',['uses'=>'HomeController@Index']);
Route::get('/404',['uses'=>'HomeController@file_not_found']);
Route::get('/chat',['uses'=>'ChatController@Index']);
Route::get('/sendMail',['uses'=>'HomeController@sendMail']);
Route::get('/profile',['uses'=>'HomeController@profile'])->middleware('guest');
Route::get('/product/{id}',['uses'=>'HomeController@detailProduct']);
Route::get('/category/{id}',['uses'=>'HomeController@detailPC']);
Route::get('/producer/{id}',['uses'=>'HomeController@detailPC']);
Route::get('/producer',['uses'=>'HomeController@listPC']);
Route::get('/category',['uses'=>'HomeController@listPC']);
Route::get('/cart',['uses'=>'HomeController@cart']);
Route::get('/cart/payment',['uses'=>'HomeController@payment']);

Route::get('/verify',['uses'=>'VerifyController@index']);
Route::get('/logout',['uses'=>'VerifyController@logout']);
Route::prefix('ajax')->group(function(){
    Route::get('changeProvince',['uses'=>'HomeController@changeProvince']);
    Route::post('addCart',['name'=>'addCart','uses'=>'HomeController@addCart']);
    Route::put('updateCart',['name'=>'updateCart','uses'=>'HomeController@updateCart']);
    Route::post('updateProfile',['name'=>'updateProfile','uses'=>'HomeController@updateProfile']);
    Route::post('removeCart',['name'=>'removeCart','uses'=>'HomeController@removeCart']);
    Route::post('login',['name'=>'login','uses'=>'VerifyController@login']);
    Route::post('register',['name'=>'register','uses'=>'VerifyController@register']);
    Route::post('payment_success',['uses'=>'HomeController@paymentSuccess']);

});
