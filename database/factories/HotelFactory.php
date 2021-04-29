<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstNameFemale,
            'stars' => random_int(1, 5),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
        ];
    }
}
