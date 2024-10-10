<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Item::simplePaginate(100);
        return response()->json(
            [
                'data' => $items
            ]
        );
    }

    public function show(Item $item): JsonResource
    {

        return new ItemResource($item->load([
            'itemRoutings.workCenter',
            'dimension',
            'itemBoms.material',
        ]));
    }
}
