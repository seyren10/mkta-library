<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ItemService
{
    public static function getItemCodes(): Collection
    {
        return Item::query()->pluck('code');
    }

    public function search(string $query): Builder
    {
        info('pinasok mo paring hayup ka?');
        return Item::query()->whereAny([
            'code',
            'description'
        ], 'LIKE', "%{$query}%");
    }
}
