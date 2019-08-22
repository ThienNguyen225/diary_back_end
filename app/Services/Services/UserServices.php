<?php


namespace App\Services\Services;


use App\Repositories\Contracts\UserInterface;
use App\Services\Contracts\UserServiceInterface;

class UserServices extends Service implements UserServiceInterface
{

    public function __construct(UserInterface $userRepository)
    {
        $this->setUserRepository($userRepository);
    }
}
