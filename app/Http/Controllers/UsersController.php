<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    //用户登录
    public function register(Request $request)
    {
       $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'avatar' => '/images/avatars/elliot.jpg',
            'password' => $request['password'],
        ]);
        return json_encode(["user" => $user, "status" => true]);
    }


    //用户登录
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'],'password'=>$request['password']])) {
            $user = $this->user->byEmail($request['email']);
            return json_encode(['user' => $user, 'status' => "success"]);
        }
        return json_encode(['user' => null, 'status' => "fail"]);
    }

    //用户的收藏列表
    public function collectList($userId)
    {

    }

    //用户的个人信息
    public function getUser($userId)
    {

    }
}
