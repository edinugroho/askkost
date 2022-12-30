<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Owner;
use App\Repositories\OwnerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_owner()
    {
        $owner = Owner::factory()->make();

        app(OwnerRepository::class)->save($owner);

        $this->assertDatabaseHas('owners', [
            'name' => $owner->name
        ]);
    }

    public function test_can_find_user_by_email()
    {
        $owner = Owner::factory()->make([
            'email' => 'email@mail.co'
        ]);
        $owner->save();

        $result = app(OwnerRepository::class)->find($owner->email);

        $this->assertModelExists($result);
    }
}
