<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Tour;
use App\Repositories\HotelRepository;
use Illuminate\Database\QueryException;
use function Functional\select;
use function Functional\true;

class HotelController extends BaseController
{
    private HotelRepository $hotelRepository;

    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    public function getByCountry(string $country): array
    {
        return $this->responseSuccess(select($this->hotelRepository->all(), fn(Hotel $hotel) => $hotel->country == $country));
    }

    public function create(string $name, int $stars, string $country, string $city, string $address): array
    {
        try {
            return true([
                strlen(urldecode($name)) > Hotel::MIN_NAME_LENGTH,
                $stars >= Hotel::MIN_STARS, $stars <= Hotel::MAX_STARS,
                strlen(urldecode($country)) > Hotel::MIN_COUNTRY_LENGTH,
                strlen(urldecode($city)) > Hotel::MIN_CITY_LENGTH,
                strlen(urldecode($address)) > Hotel::MIN_ADDRESS_LENGTH,
            ])
                ? with($this->hotelRepository->create([
                    'name' => urldecode($name),
                    'stars' => $stars,
                    'country' => urldecode($country),
                    'city' => urldecode($city),
                    'address' => urldecode($address),
                ]), fn(Hotel $hotel) => empty($hotel->id)
                    ? $this->responseFail(
                        'Internal error: could not save', static::HTTP_INTERNAL_ERROR
                    )
                    : $this->responseSuccess([$hotel])
                )
                : $this->responseFail('There is an error in your request parameters');
        } catch (QueryException $e) {
            return $this->responseFail($e->getMessage(), static::HTTP_INTERNAL_ERROR);
        }
    }
}
