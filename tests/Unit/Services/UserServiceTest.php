<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Services\UserService;
use InvalidArgumentException;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

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

        $this->instance(UserRepository::class, Mockery::mock(UserRepository::class, function ($mock) use ($data) {
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
    
    public function test_it_throw_error_when_empty_type()
    {
        $data = [
            'name' => 'name', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password', 
            'type' => '', 
            'credit' => 20
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The type field is required.');

        app(UserService::class)->saveUser($data);
    }

    public function test_it_throw_error_when_empty_type_and_name()
    {
        $data = [
            'name' => '', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password', 
            'type' => '', 
            'credit' => 20
        ];

        $this->expectException(InvalidArgumentException::class);

        app(UserService::class)->saveUser($data);
    }

    public function test_it_throw_error_when_invalid_all_field()
    {
        $data = [
            'name' => '', 
            'username' => '', 
            'email' => 'email', 
            'password' => '', 
            'type' => ''
        ];

        $this->expectException(InvalidArgumentException::class);

        app(UserService::class)->saveUser($data);
    }

    public function test_it_can_validate_data()
    {
        $data = [
            'email' => '', 
            'password' => '',
        ];
        
        $this->expectException(InvalidArgumentException::class);

        app(UserService::class)->check($data);
    }
}
