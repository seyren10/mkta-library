<?php

namespace App\Http\Controllers;

use App\Enums\Sequence;
use App\Models\Item;
use App\Models\ItemRouting;
use App\Http\Resources\ItemRoutingResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Routing for Item that includes boms and is sequenced
 */

class RoutingController extends Controller
{
    public function index(Item $item): JsonResource|string
    {
        $routings = $item->itemRoutings->makeHidden(['work_center_abbr', 'routing_no']);
        return ItemRoutingResource::collection($routings);
    }

    public function show(Item $item, int|string $id): JsonResource
    {
        /**
         * @var ItemRouting $routing 
         */

        $routing = $item->itemRoutings()->with(['files','notes'])->findOrFail($id);
        $boms = $item->itemBoms()->with(['material'])->filterByWorkCenter($routing->work_center_abbr)->get();

        return new ItemRoutingResource($routing, $boms);
    }

    public function nextSequence(Item $item, int $sequence_index): JsonResponse
    {
        $routing = $item->itemRoutings()->sequence($sequence_index, Sequence::NEXT)->firstOrFail();

        return response()->json(['data' => $routing]);
    }

    public function prevSequence(Item $item, int $sequence_index): JsonResponse
    {
        $routing = $item->itemRoutings()->sequence($sequence_index, Sequence::PREVIOUS)->firstOrFail();

        return response()->json(['data' => $routing]);
    }
}
