<?php

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;
use App\Repositories\OwnerRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OwnerService 
{
    public $ownerRepository;

    public function __construct() {
        $this->ownerRepository = app(OwnerRepository::class);
    }

    public function saveUser($data)  
    {
        $validator = Validator::make($data, [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:owners,email'],
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        return $this->ownerRepository->save($data);
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

        $owner = $this->ownerRepository->find($data['email']);

        if (!$owner && !Hash::check($data['password'], $owner['password'])) {
            throw ValidationException::withMessages([
                'email' => ['Credentials are incorrect.'],
            ]);
        }

        return [
            'owner' => $owner,
            'token' => $owner->createToken('api', ['role:owner'])->plainTextToken
        ];
    }
}
