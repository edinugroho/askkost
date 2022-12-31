<?php

namespace Database\Factories;

use App\Models\Kost;
use App\Models\User;
use App\Models\Owner;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{

    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kost_id' => Kost::all()->random()->id,
            'owner_id' => Owner::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement(['asked', 'answered']),
            'available' => $this->faker->randomElement(['yes', 'no']),
        ];
    }
}
