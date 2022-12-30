<?php

namespace App\Repositories;

use App\Models\Owner;

class OwnerRepository 
{
    public function __construct() {
        $this->owner = app(Owner::class);
    }

    public function save($owner)
    {
        $this->owner = $owner;

        $user['password'] = bcrypt($owner['password']);

        return $this->owner->save();
    }
}
