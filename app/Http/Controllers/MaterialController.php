<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class MaterialController extends Controller
{
    public function index(): JsonResponse
    {

        $materials = Material::simplePaginate(100);

        return response()->json(
            [
                'data' => $materials
            ]
        );
    }

    public function show(Material $material): JsonResponse
    {
        return response()->json([
            'data' => $material
        ]);
    }
}
