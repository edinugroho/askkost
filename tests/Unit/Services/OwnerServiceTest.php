<?php

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\Kost;
use App\Models\Owner;
use InvalidArgumentException;
use App\Services\OwnerService;
use App\Repositories\KostRepository;
use App\Repositories\OwnerRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class OwnerServiceTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_owner_throw_error_invalid_data_when_update()
    {
        $id = 1;
        $data = [
            'name' => '',
            'location' => '',
            'type' => '',
            'price' => '',
        ];

        $this->expectException(InvalidArgumentException::class);

        app(OwnerService::class)->updateKost($data, $id);
    }

    public function test_owner_can_update_kost()
    {
        Owner::factory()->create([
            'id' => 2
        ]);
        $id = 1;
        $data = [
            'owner_id' => 2,
            'name' => 'name',
            'location' => 'location',
            'type' => 'man',
            'price' => 100000,
        ];
        
        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($data, $id) {
            $mock->shouldReceive('findByid')->with($id)->once()->andReturn(Kost::factory()->make());
            $mock->shouldReceive('update')->with($data, $id)->once()->andReturn(true);
        }));

        app(OwnerService::class)->updateKost($data, $id);
    }
    
    public function test_owner_cant_update_kost()
    {
        Owner::factory()->create();
        $id = 1;
        $data = [
            'owner_id' => 99,
            'name' => 'name',
            'location' => 'location',
            'type' => 'man',
            'price' => 100000,
        ];
        
        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($id) {
            $mock->shouldReceive('findByid')->with($id)->once()->andReturn(Kost::factory()->make());
        }));

        $this->expectException(AuthenticationException::class);

        app(OwnerService::class)->updateKost($data, $id);
    }

    public function test_owner_cant_delete_kost()
    {
        $id = 1;
        $data = [
            'id' => 1,
            'name' => 'name',
            'location' => 'location',
            'type' => 'man',
            'price' => 100000,
        ];
        Owner::factory()->create();
        Kost::factory()->create($data);

        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($id) {
            $mock->shouldReceive('findByid')->with($id)->once()->andReturn(Kost::factory()->make());
        }));

        $this->expectException(AuthenticationException::class);

        app(OwnerService::class)->deleteKost($data, $id);
    }

    public function test_owner_can_delete_kost()
    {
        $id = 1;
        $owner = [
            'id' => 3
        ];
        $data = [
            'id' => 1,
            'owner_id' => 3,
            'name' => 'name',
            'location' => 'location',
            'type' => 'man',
            'price' => 100000,
        ];
        Owner::factory()->create($owner);
        Kost::factory()->create($data);

        $this->instance(KostRepository::class, Mockery::mock(KostRepository::class, function ($mock) use ($id) {
            $mock->shouldReceive('findByid')->with($id)->once()->andReturn(Kost::factory()->make());
            $mock->shouldReceive('delete')->with($id)->once()->andReturn(true);
        }));

        app(OwnerService::class)->deleteKost($owner['id'], $id);
    }
}
