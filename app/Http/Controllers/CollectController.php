<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    protected $collect;

    //用户收藏一篇新闻
    public function collect(Request $request)
    {
        $user = User::find($request['user_id']);
        $collect = $user->collectThis($request['news_id']);
        if(count($collect['detached'])>0){//如果是取消收藏
            return response()->json(['status' => "cancel"]);
        }
        return response()->json(['status' => "collect"]);
    }

    //用户是否收藏一篇新闻
    public function isCollect($userId,$newId)
    {
        $user = User::find($userId);
        $collect = $user->isCollected($newId);
        if($collect){
            return response()->json(['status' => "success"]);
        }
        return response()->json(['status' => "failed"]);
    }
}
