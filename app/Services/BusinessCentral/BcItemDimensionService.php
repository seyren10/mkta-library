<?php

// declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\DTOs\BcJsonData;
use App\Models\ItemDimension;
use App\Traits\HasCreate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcItemDimensionService
{
    use HasCreate;

    public function createItemDimensions(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data, ItemDimension::class, $chunkSize);
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        ItemDimension::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }
}
