<?php


namespace App\Repositories;


use App\User;

class CollectRepository
{
    public function collectThisNews($userId,$newsId)
    {
        $user = User::find($userId);
        $user->collectThis($newsId);
    }
}