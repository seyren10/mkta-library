<?php

namespace App\Http\Controllers;

use App\Enums\LibraryFolder;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $perPage = $request->query('perPage') ?? 100;
        $items = Item::with(['files' => fn($query) => $this->getFirstImageAsThumbnail($query)])
            ->simplePaginate($perPage);
        return ItemResource::collection($items);
    }

    public function show(Item $item): JsonResource
    {

        return new ItemResource($item->load([
            'files' => fn($query) => $this->getFirstImageAsThumbnail($query),
            'itemRoutings.workCenter',
            'dimension',
            'itemBoms.material',
        ]));
    }

    private function getFirstImageAsThumbnail(MorphMany $query): MorphMany
    {
        return $query
            ->where('file_type', LibraryFolder::IMAGES)
            ->limit(1);
    }
}
