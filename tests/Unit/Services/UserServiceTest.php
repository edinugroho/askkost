<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Services\UserService;
use App\Repositories\userRepository;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_user()
    {
        $data = [
            'name' => 'name', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password', 
            'type' => 'regular', 
            'credit' => 20
        ];

        $this->instance(userRepository::class, Mockery::mock(userRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('save')->with($data)->once();
        }));

        app(UserService::class)->saveUser($data);
    }
}
