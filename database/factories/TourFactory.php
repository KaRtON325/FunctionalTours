<?php

namespace Database\Factories;

use App\Enums\TourType;
use App\Enums\TourMeals;
use App\Models\Tour;
use App\Repositories\HotelRepository;
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
    public function definition()
    {
        $hotelRepository = new HotelRepository();
        $hotelId = array_rand($hotelRepository->allIds());
        $hotel = $hotelRepository->getById($hotelId);

        return [
            'hotel_id' => $hotelId,
            'name' => $this->faker->unique()->title,
            'country' => $hotel->country,
            'type' => array_rand(TourType::asArray()),
            'meals' => array_rand(TourMeals::asArray()),
            'start_date' => $startDate = $this->faker->dateTime,
            'end_date' => $startDate->modify(sprintf('+ %d day', random_int(1, 40))),
        ];
    }
}
