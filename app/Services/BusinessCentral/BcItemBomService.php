<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Models\ItemBom;
use App\DTOs\BcJsonData;
use App\Traits\HasCreate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcItemBomService
{
    use HasCreate;
    public function createItemBoms(Collection $data): static
    {
        return $this->create($data, ItemBom::class);
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        ItemBom::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }
}
