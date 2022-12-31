<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\Kost;
use App\Models\User;
use App\Models\Owner;
use App\Services\UserService;
use InvalidArgumentException;
use App\Repositories\KostRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_it_throw_error_if_password_not_match()
    {
        $data = [
            'email' => 'email@mail.co', 
            'password' => 'password',
        ];

        $this->instance(UserRepository::class, Mockery::mock(UserRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('find')->with($data['email'])->once()->andReturn(null);
        }));

        $this->expectException(ValidationException::class);
        
        app(UserService::class)->check($data);
    }

    public function test_user_can_ask_kost()
    {
        Owner::factory()->create(['id' => 1]);
        $data = [
            'kost_id' => 1,
            'user_id' => 1,
            'status' => 'asked',
            'owner_id' => 1
        ];

        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('findById')->with($data['kost_id'])->once()->andReturn(Kost::factory()->make());
        }));
        
        $this->instance(UserRepository::class, Mockery::mock(UserRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('findById')->with($data['user_id'])->once()->andReturn(User::factory()->make());
            $mock->shouldReceive('decreaseCreditById')->with($data['user_id'])->once()->andReturn(true);
        }));

        $this->instance(QuestionRepository::class, Mockery::mock(QuestionRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('ask')->with($data)->once()->andReturn(true);
        }));

        app(UserService::class)->ask($data);
    }

    public function test_user_cant_ask_while_credit_is_up()
    {
        Owner::factory()->create(['id' => 1]);
        $data = [
            'kost_id' => 1,
            'user_id' => 1,
            'status' => 'asked',
            'owner_id' => 1
        ];

        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('findById')->with($data['kost_id'])->once()->andReturn(Kost::factory()->make());
        }));
        
        $this->instance(UserRepository::class, Mockery::mock(UserRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('findById')->with($data['user_id'])->once()->andReturn(User::factory()->make(['credit' => 0]));
        }));

        $this->expectException(ValidationException::class);


        app(UserService::class)->ask($data);
    }
}
