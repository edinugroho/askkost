<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
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
}
