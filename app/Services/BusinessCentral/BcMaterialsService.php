<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\DTOs\BcJsonData;
use App\Models\Material;
use App\Traits\HasCreate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcMaterialsService
{
    use HasCreate;
    public function createMaterials(Collection $data, int $chunkSize = 1000): static
    {
        return $this->create($data, Material::class, $chunkSize);
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        Material::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }
}
