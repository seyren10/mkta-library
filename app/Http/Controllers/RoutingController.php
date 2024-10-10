<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRouting;
use App\Http\Resources\ItemRoutingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoutingController extends Controller
{
    public function index(Item $item): JsonResource|string
    {
        $routings = $item->itemRoutings->makeHidden(['work_center_abbr', 'routing_no']);
        return ItemRoutingResource::collection($routings);
    }

    public function show(Item $item, int $id): JsonResource
    {
        /**
         * @var ItemRouting routing 
         */

        $routing = $item->itemRoutings()->findOrFail($id);
        $boms = $item->itemBoms()->filterByWorkCenter($routing->work_center_abbr)->get();

        return new ItemRoutingResource($routing, $boms);
    }
}
