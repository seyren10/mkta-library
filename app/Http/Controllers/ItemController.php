<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Enums\FileType;
use Illuminate\Support\Str;
use App\Enums\LibraryFolder;

use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ItemController extends Controller
{
    public function index(Request $request, ItemService $itemService): JsonResource
    {
        $perPage = $request->query('perPage') ?? 100;

        $searchQuery = $request->query('q');

        $items = Item::when($searchQuery,  fn() => $itemService->search($request->q))
            ->with(['files' => fn($query) => $this->getFirstImageAsThumbnail($query)])
            ->simplePaginate($perPage)
            ->withQueryString();
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
            ->where('file_type', FileType::Images)
            ->limit(1);
    }
}
