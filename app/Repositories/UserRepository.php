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

        $user['password'] = bcrypt($user['password']);
        $user['credit'] = $user['type'] == 'regular' ? 20 : 40;

        return $this->user->save();
    }
}
