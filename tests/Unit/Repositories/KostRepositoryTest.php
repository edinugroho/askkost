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

    public function test_it_can_update_kost_by_id()
    {
        $kost = Kost::factory()->create();
        $data = [
            'name' => 'new name',
            'location' => 'new location',
            'type' => 'woman',
            'price' => 900000,
        ];

        app(KostRepository::class)->update($data, $kost->id);

        $this->assertDatabaseHas('kosts', [
            'name' => $data['name']
        ]);
    }
}