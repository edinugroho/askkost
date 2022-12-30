<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{
    public function __construct() {
        $this->user = app(User::class);
    }

    public function save($user)
    {
        $this->user['name'] = $user['name'];
        $this->user['email'] = $user['email'];
        $this->user['username'] = $user['username'];
        $this->user['type'] = $user['type'];
        $this->user['password'] = bcrypt($user['password']);
        $this->user['credit'] = $user['type'] == 'regular' ? 20 : 40;
        
        return $this->user->save();
    }
}
