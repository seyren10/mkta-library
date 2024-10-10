<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Models\Item;
use App\Models\BcBom;
use App\Models\BcRouting;
use App\Models\ItemDimension;
use App\Traits\HasCreate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcItemService
{
    use HasCreate;
    
    public function createBoms(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data, BcBom::class, $chunkSize);
    }
    public function createRoutings(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data, BcRouting::class, $chunkSize);
    }

    public function createItems(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data,  Item::class, $chunkSize);
    }
    public function createDimensions(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data,  ItemDimension::class, $chunkSize);
    }


    public function truncateBcRoutings()
    {
        Schema::disableForeignKeyConstraints();
        BcRouting::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }

    public function truncateBcBoms()
    {
        Schema::disableForeignKeyConstraints();
        BcBom::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }

    public function truncateItems()
    {
        Schema::disableForeignKeyConstraints();
        Item::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }
    public function truncateDimensions()
    {
        Schema::disableForeignKeyConstraints();
        ItemDimension::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }

    public static function getCodeCollection(): Collection
    {
        return Item::query()->pluck('code')->collect();
    }
}
