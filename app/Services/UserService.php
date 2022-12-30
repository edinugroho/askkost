<?php

namespace App\Services;

use App\Repositories\userRepository;

class UserService 
{
    public $userRepository;

    public function __construct() {
        $this->userRepository = app(userRepository::class);
    }

    public function saveUser($data)  
    {
        return $this->userRepository->save($data);
    }
}
