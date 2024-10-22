<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRoutingUploadFilesRequest;
use App\Models\ItemRouting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemRoutingController extends Controller
{

    public function index()
    {
        return response()->json(
            [
                'data' => ItemRouting::simplePaginate(100)
            ]
        );
    }


    public function show(ItemRouting $item_routing): JsonResponse
    {
        return response()->json([
            'data' => $item_routing->load('workCenter')->makeHidden('work_center_abbr')
        ]);
    }
}
