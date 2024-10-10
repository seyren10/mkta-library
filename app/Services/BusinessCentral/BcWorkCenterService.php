<?php

declare(strict_types=1);

namespace App\Services\BusinessCentral;

use App\Traits\HasCreate;
use App\Models\WorkCenter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class BcWorkCenterService
{
    use HasCreate;
    public function createWorkCenters(Collection $data)
    {
        return   $this->create($data, WorkCenter::class);
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        WorkCenter::truncate();
        Schema::enableForeignKeyConstraints();

        return $this;
    }
}
