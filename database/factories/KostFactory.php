<?php

namespace Database\Factories;

use App\Models\Kost;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class KostFactory extends Factory
{

    protected $model = Kost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_id' => Owner::all()->random()->id,
            'name' => $this->faker->name(),
            'location' => $this->faker->city(),
            'type' => $this->faker->randomElement(['together', 'man', 'woman']),
            'price' => $this->faker->regexify('[1-9]000000')
        ];
    }
}
