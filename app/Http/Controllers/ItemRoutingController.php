<?php

namespace App\Http\Controllers;

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


    public function show(ItemRouting $itemRouting): JsonResponse
    {
        return response()->json([
            'data' => $itemRouting->load('workCenter')->makeHidden('work_center_abbr')
        ]);
    }
}
