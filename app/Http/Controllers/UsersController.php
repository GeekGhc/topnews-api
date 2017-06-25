<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Validator;
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
        $valName = Validator::make($request->all(),[
            'name' => 'required|unique:users',
        ]);
        if($valName->fails()){
            return response()->json([
                'msg'=>'用户名已存在',
                'user'=>null,
                'status'=>'failed'
            ]);
        }
        $valEmail = Validator::make($request->all(),[
            'email' => 'required|unique:users',
        ]);
        if($valEmail->fails()){
            return response()->json([
                'msg'=>'邮箱已经被注册',
                'user'=>null,
                'status'=>'failed'
            ]);
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'avatar' => '/images/avatars/elliot.jpg',
            'password' => $request['password'],
            'social_type'=>'local',
        ]);
        return json_encode(["user" => $user, "status" => "success"]);
    }


    //用户登录
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = $this->user->byEmail($request['email']);
            return json_encode(['user' => $user, 'status' => "success"]);
        }
        return json_encode(['user' => null, 'status' => "fail"]);
    }

    //第三方登录
    public function socialLogin(Request $request)
    {
        if($request['social_id'] && $request['social_type']){
            $isAuth = $this->socialIsAuth($request['social_id']);
            if($isAuth){
                $user = User::create([
                    'name' => $request['name'],
                    'email' => str_random(12),
                    'avatar' => '/images/avatars/elliot.jpg',
                    'password' => '111111',
                    'social_id' => $request['social_id'],
                    'social_type'  => $request['social_type']
                ]);
                return response()->json([
                    'status'=>"success",
                    'user'=>$user
                ]);
            }
            $user = User::where('social_id',$request['social_id'])->first();
            return response()->json([
                'status'=>"success",
                'user' => $user
            ]);
        }
        return response()->json([
            'status'=>"failed",
            'user' => null
        ]);
    }
    public function socialIsAuth($socialId)
    {
        if(User::where('social_id',$socialId)->count()){
            return false;
        }
        return true;
    }

    //用户的收藏列表
    public function collectList($userId)
    {
        $user = $this->user->byId($userId);
        $newsList = $user->collects;
        if ($user) {
            return json_encode(['newsList' => $newsList, 'status' => 'success']);
        }
        return json_encode(['newsList' => null, 'status' => "failed"]);
    }

    //用户的个人信息
    public function getUser($userId)
    {
        $user = $this->user->byId($userId);
        if ($user) {
            return json_encode(['user' => $user, 'status' => "success"]);
        }
        return json_encode(['user' => null, 'status' => "failed"]);
    }

    //更新用户信息
    public function updateInfo(Request $request)
    {
        $user = $this->user->byId($request["userId"]);
        $user->phone = $request['phone'];
        $user->desc = $request['desc'];
        $user->name = $request['name'];
        $res = $user->save();
        if ($res) {
            return json_encode(['user' => $user, 'status' => "success"]);
        }
        return json_encode(['user' => null, 'status' => "failed"]);
    }

    //修改用户密码
    public function updatePwd(Request $request)
    {
        $user = $this->user->byId($request["userId"]);
        $user->password = $request['password'];
        $res = $user->save();
        if ($res) {
            return json_encode(['user' => $user, 'status' => "success"]);
        }
        return json_encode(['user' => null, 'status' => "fail"]);
    }
}
