<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Kost;
use App\Models\Owner;
use App\Models\Facility;
use App\Repositories\FacilityRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacilityRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Owner::factory()->create();
        Kost::factory()->create();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_save_facility()
    {
        $facility = Facility::factory()->make();

        app(FacilityRepository::class)->save($facility);

        $this->assertDatabaseHas('facilities', [
            'kost_id' => $facility->kost_id
        ]);
    }
}
