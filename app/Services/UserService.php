<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\KostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserService 
{
    public $userRepository;
    public $questionRepository;
    public $kostRepository;

    public function __construct() {
        $this->userRepository = app(UserRepository::class);
        $this->questionRepository = app(QuestionRepository::class);
        $this->kostRepository = app(KostRepository::class);
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

    public function ask($data)
    {
        $kost = $this->kostRepository->findByid($data['kost_id']);

        $data['owner_id'] = $kost->owner_id;
        $data['status'] = 'asked';

        $user = $this->userRepository->findById($data['user_id']);

        if ($user->credit <= 0) {
            throw ValidationException::withMessages([
                'credit' => ['Credits are up.'],
            ]);
        }

        $this->userRepository->decreaseCreditById($data['user_id']);

        return $this->questionRepository->ask($data);
    }
}
