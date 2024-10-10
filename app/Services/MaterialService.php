<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Material;
use Illuminate\Support\Collection;

class MaterialService
{
    public static function getMaterialCodes():Collection
    {
        return Material::pluck('code');
    }
}
