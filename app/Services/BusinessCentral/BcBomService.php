<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Models\BcBom;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

class BcBomService
{
    public static function getBomsLazy(int $chunkSize = 1000)
    {
        return BcBom::lazy($chunkSize);
    }

    public static function getBomsDiffLazy(Collection $firstData, LazyCollection $secondData): Collection
    {
        return $firstData->diff($secondData->all());
    }

    public static function getBomCodes(): Collection
    {
        return BcBom::pluck('production_bom_no');
    }
}
