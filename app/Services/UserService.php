<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\userRepository;
use Illuminate\Support\Facades\Validator;

class UserService 
{
    public $userRepository;

    public function __construct() {
        $this->userRepository = app(userRepository::class);
    }

    public function saveUser($data)  
    {
        $validator = Validator::make($data, [
            'name' => ['required'],
            'type' => ['required', 'in:regular,premium']
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        return $this->userRepository->save($data);
    }
}
