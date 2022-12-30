<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\OwnerRepository;
use Illuminate\Support\Facades\Validator;

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
}
