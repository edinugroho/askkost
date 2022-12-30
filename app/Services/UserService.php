<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    public function check($data)
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        $user = $this->userRepository->find($data['email']);

        if (!$user && !Hash::check($data['password'], $user['password'])) {
            throw ValidationException::withMessages([
                'email' => ['Credentials are incorrect.'],
            ]);
        }

        return [
            'user' => $user,
            'token' => $user->createToken('api', ['role:user'])->plainTextToken
        ];
    }
}
