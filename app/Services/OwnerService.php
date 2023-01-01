<?php

namespace App\Services;

use InvalidArgumentException;
use App\Repositories\KostRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\OwnerRepository;
use App\Repositories\FacilityRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class OwnerService 
{
    public $ownerRepository;
    public $kostRepository;
    public $facilityRepository;
    public $questionRepository;

    public function __construct() {
        $this->ownerRepository = app(OwnerRepository::class);
        $this->kostRepository = app(KostRepository::class);
        $this->facilityRepository = app(FacilityRepository::class);
        $this->questionRepository = app(QuestionRepository::class);
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

    public function saveKost($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required'],
            'location' => ['required'],
            'type' => ['required', 'in:man,woman,together'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        return $this->kostRepository->save($data);
    }

    public function updateKost($data, $id)
    {
        $validator = Validator::make($data, [
            'type' => ['required', 'in:man,woman,together'],
            'price' => ['required', 'numeric'],
        ]);
        
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }
        
        if ($this->kostRepository->findByid($id)->owner_id != $data['owner_id']) {
            throw new AuthenticationException;
        }

        return $this->kostRepository->update($data, $id);
    }

    public function deleteKost($owner_id, $id)
    {   
        if ($this->kostRepository->findByid($id)->owner_id != $owner_id) {
            throw new AuthenticationException;
        }

        return $this->kostRepository->delete($id);
    }

    public function facilityKost($data, $id)
    {
        $validator = Validator::make($data, [
            'parking' => ['required', 'in:car,motorcycle,car and motorcycle'],
            'bathroom' => ['required', 'in:inside,outside'],
            'security' => ['required', 'in:yes,no'],
            'table' => ['required', 'in:yes,no'],
            'chair' => ['required', 'in:yes,no'],
            'cupboard' => ['required', 'in:yes,no'],
            'bed' => ['required', 'in:yes,no'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors());
        }

        if ($this->kostRepository->findByid($id)->owner_id != $data['owner_id']) {
            throw new AuthenticationException;
        }

        return $this->facilityRepository->save($data);
    }

    public function answer($data)
    {
        if ($this->kostRepository->findByid($data['kost_id'])->owner_id != $data['owner_id']) {
            throw new AuthenticationException;
        }

        $data['status'] = 'answered';

        return $this->questionRepository->answer($data);
    }
}
