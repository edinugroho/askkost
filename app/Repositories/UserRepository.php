<?php

namespace App\Repositories;

use App\Models\User;

class userRepository 
{
    public function __construct() {
        $this->user = app(User::class);
    }

    public function save($user)
    {
        $this->user = $user;

        return $this->user->save();
    }
}
