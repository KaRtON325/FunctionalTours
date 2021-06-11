<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Models\Tour;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use function Functional\map;
use function Functional\select;

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
        return map($this->all(), fn($hotel) => $hotel->id);
    }

    public function getById(int $id): Hotel
    {
        return head(select($this->all(), fn($hotel) => $hotel->id === $id));
    }

    public function create(array $attributes): Hotel
    {
        return with(new Hotel(), function(Hotel $hotel) use ($attributes) {
            return tap($hotel, fn() => $hotel->setRawAttributes($attributes)->save());
        });
    }
}
