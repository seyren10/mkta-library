<?php

namespace App\Http\Resources;

use App\Services\File\FileCollectionService;
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

        // $data['thumbnail'] = $this->when($this->whenLoaded('files') && $this->files->isNotEmpty(), function () {
        //     return FileCollectionService::toUrl($this->files->first()->path);
        // });

        $data['thumbnail'] = $this->whenLoaded('files', function () {
            if ($this->files->isNotEmpty())
                return FileCollectionService::toUrl($this->files->first()->path);
        });

        if ($data['thumbnail'] === null) {
            unset($data['thumbnail']);
        }

        unset($data['item_boms'], $data['files']);
        return $data;
    }
}
