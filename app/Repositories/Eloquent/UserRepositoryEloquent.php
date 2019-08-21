<?php


namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\UserInterface;
use App\User;

class UserRepositoryEloquent extends RepositoryEloquent implements UserInterface
{

    public function getModel()
    {
        return User::class;
    }
}
