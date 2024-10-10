<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Collection;

class ItemService
{

    public static function getItemCodes(): Collection
    {
        return Item::query()->pluck('code');
    }
}
