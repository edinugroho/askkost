<?php

namespace Database\Factories;

use App\Models\Kost;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityFactory extends Factory
{

    protected $mode = Factory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kost_id' => Kost::all()->random()->id,
            'parking' => $this->faker->randomElement(['car', 'motorcycle', 'car and motorcycle']),
            'bathroom' => $this->faker->randomElement(['inside', 'outside']),
            'security' => $this->faker->randomElement(['yes', 'no']),
            'table' => $this->faker->randomElement(['yes', 'no']),
            'chair' => $this->faker->randomElement(['yes', 'no']),
            'cupboard' => $this->faker->randomElement(['yes', 'no']),
            'bed' => $this->faker->randomElement(['yes', 'no']),
        ];
    }
}
