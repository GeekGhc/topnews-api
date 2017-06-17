<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','phone','desc'
    ];

    //在数据保存到数据库之前会对密码进行一个预处理
    public function setPasswordAttribute($password){
        $this->attributes['password'] = \Hash::make($password);
    }


    //用户----评论
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }


    //用户----新闻
    public function collects()
    {
        return $this->belongsToMany(News::class)->withTimestamps();
    }
    //用户收藏该新闻
    public function collectThis($newsId)
    {
        return $this->collects()->toggle($newsId);
    }

    //用户收藏了改新闻
    public function isCollected($newsId)
    {
        return $this->collects()->where('new_id',$newsId)->count();
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
