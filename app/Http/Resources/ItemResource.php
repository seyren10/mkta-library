<?php

namespace App\Http\Resources;

use App\Models\Item;
use App\Models\ItemBom;
use App\Models\ItemRouting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['item_routings'] = ItemRoutingResource::collection($this->whenLoaded('itemRoutings'));
        unset($data['item_boms']);
        return $data;
    }
}
