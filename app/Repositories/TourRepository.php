<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use function Functional\map;
use function Functional\select;

class TourRepository implements HotelRepositoryInterface
{
    /**
     * @return Hotel[]|Collection
     */
    public function all(): array|Collection
    {
        return Hotel::all();
    }

    public function allIds(): array
    {
        return map($this->all(), fn ($tour) => $tour->id);
    }

    public function getById(int $id): Hotel
    {
        return head(select($this->all(), fn ($tour) => $tour->id === $id));
    }
}
