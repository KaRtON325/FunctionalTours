<?php

namespace App\Repositories\Interfaces;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;

interface HotelRepositoryInterface
{
    public function all(): array|Collection;

    public function allIds(): array;

    public function getById(int $id): Hotel;
}
