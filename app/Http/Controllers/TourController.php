<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Repositories\TourRepository;
use Laravel\Lumen\Routing\Controller as BaseController;
use function Functional\select;
use function Functional\every;
use function Functional\concat;

class TourController extends BaseController
{
    private TourRepository $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function getByCountry(string $country) {
        $this->showResult(select($this->tourRepository->all(), fn (Hotel $hotel) => $hotel->country == $country));
    }

    private function showResult(array $result) {
        return every($result, fn ($value, $key) => $this->tableRow($key, $value));
    }

    private function tableRow(string $title, string $value): void {
        echo concat('<div>', $title, '</div><div>', $value, '</div>');
    }
}
