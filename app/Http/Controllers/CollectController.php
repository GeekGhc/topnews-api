<?php

namespace App\Http\Controllers;

use App\News;
use App\User;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    protected $collect;

    //用户收藏一篇新闻
    public function collect(Request $request)
    {
        $hasNews = News::where('news_url',$request['newsUrl'])->first();
        $user = User::find($request['userId']);
        if (!$hasNews){
            $news = News::create(['news_url'=>$request['newsUrl']]);
            $collect = $user->collectThis($news->id);
            return response()->json(['status' => "collect"]);
        }else{
            $news = News::destroy($hasNews->id);
            $collect = $user->collectThis($hasNews->id);
            return response()->json(['status' => "cancel"]);
        }
    }

    //用户是否收藏一篇新闻
    public function isCollect(Request $request)
    {
        $news = News::where('news_url',$request['newsUrl'])->first();
        if($news){
            $user = User::find($request['userId']);
            $collect = $user->isCollected($news->id);
            if($collect){
                return response()->json(['status' => "success"]);
            }
        }
        return response()->json(['status' => "failed"]);
    }
}
