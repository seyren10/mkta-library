<?php

declare(strict_types=1);

namespace App\Enums;

enum BcContext
{
    case WorkCenters;
    case Dimensions;
    case RoutingLines;
    case BOMLines;
    case Items;
    case Materials;

    public function getContextLink(): string
    {
        return match ($this) {
            static::WorkCenters => config('bc.links.work_centers'),
            static::Dimensions => config('bc.links.dimensions'),
            static::BOMLines => config('bc.links.bom_lines'),
            static::Items => config('bc.links.item_list'),
            static::Materials => config('bc.links.materials'),
            static::RoutingLines => config('bc.links.routing_lines'),
        };
    }
}
