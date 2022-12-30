<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class UserService 
{
    public $userRepository;

    public function __construct() {
        $this->userRepository = app(UserRepository::class);
    }

    public function saveUser($data)  
    {
        $validator = Validator::make($data, [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required'],
            'password' => ['required'],
            'type' => ['required', 'in:regular,premium']
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        return $this->userRepository->save($data);
    }
}
