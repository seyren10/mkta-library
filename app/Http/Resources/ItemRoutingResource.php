<?php

namespace App\Http\Resources;

use App\Models\ItemRouting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemRoutingResource extends JsonResource
{
    public function __construct(ItemRouting $itemRouting, private Collection|int $itemBom = 0)
    {
        parent::__construct($itemRouting);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        $data['work_center'] = $this->whenLoaded('workCenter', $this->workCenter);
        $data['files'] = $this->whenLoaded('files', function () {
            return  LibraryFilesResource::collection($this->files);
        });

        $data['boms'] = $this->when($this->isCollection($this->itemBom), $this->itemBom);

        return $data;
    }

    private function isCollection(mixed $item): bool
    {
        return $item instanceof Collection && $item !== null;
    }
}
