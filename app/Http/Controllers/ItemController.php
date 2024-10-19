<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Enums\LibraryFolder;
use Illuminate\Http\Request;

use App\Http\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
