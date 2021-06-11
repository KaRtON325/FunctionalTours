<?php

namespace App\Http\Controllers;

use App\Enums\TourMeals;
use App\Enums\TourType;
use App\Models\Tour;
use App\Repositories\TourRepository;
use Illuminate\Database\QueryException;
use function Functional\contains;
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
        return $this->responseSuccess(select($this->tourRepository->all(), fn(Tour $tour) => $tour->hotel->country == $country));
    }

    public function getByType(string $type): array
    {
        return contains(TourType::getValues(), $type)
            ? $this->responseSuccess(select($this->tourRepository->all(), fn(Tour $tour) => $tour->type == $type))
            : $this->responseFail('There is no such type available');
    }

    public function getByMeals(string $meals): array
    {
        return contains(TourMeals::getValues(), $meals)
            ? $this->responseSuccess(select($this->tourRepository->all(), fn(Tour $tour) => $tour->meals == $meals))
            : $this->responseFail('There is no such meals available');
    }

    public function getByHotel(string $hotel): array
    {
        return $this->responseSuccess(select($this->tourRepository->all(), fn(Tour $tour) => $tour->hotel->name == $hotel));
    }

    public function find(string $type, string $start_date = '', string $end_date = ''): array
    {
        return contains(TourType::getValues(), $type)
            ? $this->responseSuccess(
                select(
                    $this->tourRepository->all(),
                    fn(Tour $tour) => true([
                        $tour->type == $type,
                        some([empty($start_date), $tour->start_date === $start_date]),
                        some([empty($end_date), $tour->end_date === $end_date])
                    ])
                )
            )
            : $this->responseFail('There is no such meals available');
    }

    public function create(int $hotel_id, string $name, string $type, string $meals, float $price, string $start_date, string $end_date): array
    {
        try {
            return true([
                $hotel_id > 0,
                strlen(urldecode($name)) > Tour::MIN_NAME_LENGTH,
                contains(TourType::getValues(), $type),
                contains(TourMeals::getValues(), $meals),
                $price > 0,
                strtotime(urldecode($start_date)) > 0,
                strtotime(urldecode($end_date)) > 0,
            ])
                ? with($this->tourRepository->create([
                    'hotel_id' => $hotel_id,
                    'name' => urldecode($name),
                    'type' => urldecode($type),
                    'meals' => urldecode($meals),
                    'price' => $price,
                    'start_date' => urldecode($start_date),
                    'end_date' => urldecode($end_date),
                ]), fn(Tour $tour) => empty($tour->id)
                    ? $this->responseFail(
                        'Internal error: could not save', static::HTTP_INTERNAL_ERROR
                    )
                    : $this->responseSuccess([$tour])
                )
                : $this->responseFail('There is an error in your request parameters');
        } catch (QueryException $e) {
            return $this->responseFail($e->getMessage(), static::HTTP_INTERNAL_ERROR);
        }
    }
}
