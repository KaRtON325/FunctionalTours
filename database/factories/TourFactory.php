<?php

namespace Database\Factories;

use App\Enums\TourType;
use App\Enums\TourMeals;
use App\Models\Hotel;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return with(Hotel::factory()->create(), function (Hotel $hotel) {
            return [
                'hotel_id' => $hotel->id,
                'name' => $this->faker->unique()->name,
                'type' => TourType::getRandomValue(),
                'meals' => TourMeals::getRandomValue(),
                'start_date' => $startDate = $this->faker->dateTime,
                'end_date' => $startDate->modify(sprintf('+ %d day', random_int(1, 40))),
                'price' => rand(1, 10) / 10 * random_int(100000, 9000000),
            ];
        });
    }
}
