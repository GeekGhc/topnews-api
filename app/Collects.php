<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collects extends Model
{
    protected $fillable = [
        'user_id','news_id'
    ];
}
