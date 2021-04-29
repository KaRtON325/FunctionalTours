<?php

namespace App\Repositories\Interfaces;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;

interface TourRepositoryInterface
{
    public function all(): array|Collection;
}
