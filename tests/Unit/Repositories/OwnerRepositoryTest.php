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
        $user = Owner::factory()->make();

        app(OwnerRepository::class)->save($user);

        $this->assertModelExists($user);
    }
}
