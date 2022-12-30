<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Kost;
use App\Models\Owner;
use App\Repositories\KostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Owner::factory()->create();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_kost()
    {
        $kost = Kost::factory()->make();

        app(KostRepository::class)->save($kost);

        $this->assertDatabaseHas('kosts', [
            'name' => $kost->name
        ]);
    }
}
