<?php

namespace App\Casts;

use App\DTOs\RoutingDetailsDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RoutingDetails implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */


    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {

        $routingDetails = new RoutingDetailsDTO($model->routing_no, $model->work_center_abbr, $model->sequence_index);
        return $routingDetails->getRaw();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
