<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Models\Tour;
use App\Repositories\Interfaces\TourRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use function Functional\map;
use function Functional\select;

class TourRepository implements TourRepositoryInterface
{
    /**
     * @return Hotel[]|Collection
     */
    public function all(): array|Collection
    {
        return Tour::all();
    }

    public function allIds(): array
    {
        return map($this->all(), fn ($tour) => $tour->id);
    }

    public function getById(int $id): Tour
    {
        return head(select($this->all(), fn ($tour) => $tour->id === $id));
    }

    public function create(array $attributes): Tour
    {
        return with(new Tour(), function(Tour $tour) use ($attributes) {
            return tap($tour, fn () => $tour->setRawAttributes($attributes)->save());
        });
    }
}
