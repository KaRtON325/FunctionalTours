<?php

namespace App\Http\Controllers;

use App\Enums\TourMeals;
use App\Enums\TourType;
use App\Models\Tour;
use App\Repositories\TourRepository;
use Laravel\Lumen\Routing\Controller as BaseController;
use function Functional\contains;
use function Functional\not;
use function Functional\select;
use function Functional\some;
use function Functional\true;

class TourController extends BaseController
{
    private TourRepository $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function getByCountry(string $country): array
    {
        return $this->showResult(select($this->tourRepository->all(), fn(Tour $tour) => $tour->country == $country));
    }

    public function getByType(string $type): array
    {
        return contains(TourType::getValues(), $type)
            ? $this->showResult(select($this->tourRepository->all(), fn(Tour $tour) => $tour->type == $type))
            : ['status' => false, 'error_message' => 'There is no such type available'];
    }

    public function getByMeals(string $meals): array
    {
        return contains(TourMeals::getValues(), $meals)
            ? $this->showResult(select($this->tourRepository->all(), fn(Tour $tour) => $tour->meals == $meals))
            : ['status' => false, 'error_message' => 'There is no such meals available'];
    }

    public function find(string $type, string $start_date = '', string $end_date = ''): array
    {
        return contains(TourType::getValues(), $type)
            ? $this->showResult(
                select(
                    $this->tourRepository->all(),
                    fn(Tour $tour) => true([
                        $tour->type == $type,
                        some([empty($start_date), $tour->start_date === $start_date]),
                        some([empty($end_date), $tour->end_date === $end_date])
                    ])
                )
            )
            : ['status' => false, 'error_message' => 'There is no such meals available'];
    }

    private function showResult(mixed $result): array
    {
        return ['status' => true, 'data' => array_values($result)];
    }
}
