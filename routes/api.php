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

    Route::post('/news/collect','CollectController@collect');//用户收藏一篇新闻
    Route::get('/user/{u_id}/new/{n_id}/isCollect','CollectController@isCollect');//用户是否收藏一篇新闻

    Route::post('/comment','CommentController@store');//用户评论一个新闻
    Route::get('/new/{n_id}/comments','NewsController@getComments');//一篇新闻的所有评论
});
