<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Services\UserService;
use InvalidArgumentException;
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

    public function test_it_throw_error_when_invalid_type()
    {
        $data = [
            'name' => 'name', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password', 
            'type' => 'invalid', 
            'credit' => 20
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The selected type is invalid.');

        app(UserService::class)->saveUser($data);
    }
}
