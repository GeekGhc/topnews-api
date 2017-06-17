<?php
namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }

    public function byEmail($email)
    {
        return User::where('email',$email)->first();
    }

    public function register(array $arr,$data)
    {
        $user = User::create(array_merge($arr, $data));
        return  $user;
    }
}