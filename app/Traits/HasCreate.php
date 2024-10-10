<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;

trait HasCreate
{
    public function create(Collection $data, string $model, int $chunkSize = 1000): static
    {
        info('inserting data to table' . $model);

        $chuckedData = $data->chunk($chunkSize);

        $chuckedData->each(function (Collection $chunk) use ($model) {
            $model::query()->insert($chunk->toArray());
        });

        return $this;
    }
}
