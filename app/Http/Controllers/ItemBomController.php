<?php

namespace App\Http\Controllers;

use App\Models\ItemBom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemBomController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'data' => ItemBom::simplePaginate(100)
            ]
        );
    }

    public function show(ItemBom $item_bom)
    {
        return response()->json(
            [
                'data' => $item_bom->load(['workCenter', 'material'])->makeHidden('material_code', 'work_center_abbr')
            ]
        );
    }
}
