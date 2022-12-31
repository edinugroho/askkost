<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Repositories\KostRepository;
use InvalidArgumentException;
use App\Services\OwnerService;
use App\Repositories\OwnerRepository;
use Illuminate\Validation\ValidationException;

class OwnerServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_owner()
    {
        $data = [
            'name' => 'name', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password',
        ];

        $this->instance(OwnerRepository::class, Mockery::mock(OwnerRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('save')->with($data)->once();
        }));

        app(OwnerService::class)->saveUser($data);
    }

    public function test_it_can_validate_data()
    {
        $data = [
            'email' => '', 
            'password' => '',
        ];
        
        $this->expectException(InvalidArgumentException::class);

        app(OwnerService::class)->check($data);
    }

    public function test_it_throw_error_if_password_not_match(Type $var = null)
    {
        $data = [
            'email' => 'email@mail.co', 
            'password' => 'password',
        ];

        $this->instance(OwnerRepository::class, Mockery::mock(OwnerRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('find')->with($data['email'])->once()->andReturn(null);
        }));

        $this->expectException(ValidationException::class);
        
        app(OwnerService::class)->check($data);
    }

    public function test_it_throw_error_when_empty_name()
    {
        $data = [
            'name' => '', 
            'username' => 'username', 
            'email' => 'email@mail.co', 
            'password' => 'password',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name field is required.');

        app(OwnerService::class)->saveUser($data);
    }

    public function test_owner_throw_error_invalid_data()
    {
        $data = [
            'name' => '',
            'location' => '',
            'type' => '',
            'price' => '',
        ];

        $this->expectException(InvalidArgumentException::class);

        app(OwnerService::class)->saveKost($data);
    }

    public function test_owner_can_save_kost()
    {
        $data = [
            'owner_id' => 1,
            'name' => 'name',
            'location' => 'location',
            'type' => 'man',
            'price' => 100000,
        ];

        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($data) {
            $mock->shouldReceive('save')->with($data)->once()->andReturn(true);
        }));

        app(OwnerService::class)->saveKost($data);
    }
}
