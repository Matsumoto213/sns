<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Tweet;

class TimelineController extends Controller
{
    // 
    public function showTimelinePage(){
        // resource/views/auth/timeline.blade.phpを表示する。
        

        $tweets=Tweet::latest()->get();// ツイートテーブルに保存されたツイートを新着順で取得する
        
        return view('auth.timeline',compact('tweets'));
        // compact('tweets')とすることで$tweetsをビューに送っています。

    }

    // Requestはpostリクエストを取得するためのもの。
    public function postTweet(Request $request)
    {
        // バリデーションの操作がこれだけでできる
        $validator=$request->validate([
            'tweet'=>['required', 'string', 'max:280']
            // 必須・文字であること・280文字までというバリデーションをする操作をvalidationに代入する。
        ]);
       
         Tweet::create([ // tweetテーブルに入れますという合図
            'user_id'=>Auth::user()->id, // Auth::user()は、現在ログインしているユーザーのこと
            'tweet'=>$request->tweet,// ツイート内容
        ]);
        return back(); // /timelineにリダイレクトする(リクエストを送ったページに戻る)
       
        
        
    }
}
