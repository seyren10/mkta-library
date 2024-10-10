<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Models\BcRouting;
use Illuminate\Support\Collection;

class BcRoutingService
{
    public static function getRoutingNo(): Collection
    {
        return BcRouting::pluck('routing_no');
    }
}
