<?php

namespace App\Repositories\Interfaces;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Collection;

interface TourRepositoryInterface
{
    public function all(): array|Collection;

    public function allIds(): array;

    public function getById(int $id): Tour;

    public function create(array $attributes): Tour;
}
