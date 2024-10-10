<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Traits\HasCreate;
use App\Models\ItemRouting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcItemRoutingService
{
    use HasCreate;

    public function createItemRouting(Collection $data): static
    {
        return $this->create($data, ItemRouting::class);
    }

    public function truncate(): static
    {
        Schema::disableForeignKeyConstraints();
        ItemRouting::truncate();
        Schema::enableForeignKeyConstraints();
        return $this;
    }
}
