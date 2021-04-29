<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TourRepositoryInterface
{
    public function all(): array|Collection;
}
