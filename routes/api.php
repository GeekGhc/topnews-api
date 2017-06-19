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

Route::middleware('api')->get('/user', function (Request $request) {
    return "Welcome to TopNews";
});

Route::group(['middleware'=>'api','prefix'=>'v1'],function (){
    Route::post('/user/register','UsersController@register');//用户注册
    Route::post('/user/login','UsersController@login');//用户登录
    Route::post('/user/info',"UsersController@updateInfo");//更新一个用户资料
    Route::post('/user/password',"UsersController@updatePwd");//修改用户密码

    Route::post('/news/collect','CollectController@collect');//用户收藏一篇新闻
    Route::post('/user/news','CollectController@isCollect');//用户是否收藏一篇新闻

    Route::get('/user/{userId}/news',"UsersController@collectList");//用户的收藏列表
    Route::get('/user/{userId}',"UsersController@getUser");//返回一个用户的信息

    Route::post('/comment','CommentController@store');//用户评论一个新闻
    Route::get('/new/{newId}/comments','NewsController@getComments');//一篇新闻的所有评论
});
