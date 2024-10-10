<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\WorkCenter;
use Illuminate\Support\Collection;

class WorkCentersService
{


    public static function getAbbrs(): Collection
    {
        return WorkCenter::pluck('abbr');
    }
}
