<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HotelRepository implements HotelRepositoryInterface
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
        $result = [];
        foreach ($this->all() as $hotel) {
            $result[] = $hotel->id;
        }

        return $result;
    }

    public function getById(int $id): Hotel
    {
        return Hotel::where(['id' => $id])->first();
    }
}
