<?php

namespace App\Repositories;

use App\Models\Owner;
use Illuminate\Support\Facades\Hash;

class OwnerRepository 
{
    public function __construct() {
        $this->owner = app(Owner::class);
    }

    public function save($owner)
    {
        $this->owner['name'] = $owner['name'];
        $this->owner['email'] = $owner['email'];
        $this->owner['username'] = $owner['username'];
        $this->owner['password'] = bcrypt($owner['password']);

        return $this->owner->save();
    }

    public function find($email)
    {
        return $this->owner->where([
           'email' => $email
        ])->first();
    }
}
