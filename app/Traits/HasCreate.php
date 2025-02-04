<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait HasCreate
{
    public function create(Collection $data, string $model, int $chunkSize = 1000): static
    {
        Log::driver('bc')->info('inserting data to table' . $model);

        $chuckedData = $data->chunk($chunkSize);

        $chuckedData->each(function (Collection $chunk) use ($model) {
            $model::query()->insert($chunk->toArray());
        });

        return $this;
    }
}
