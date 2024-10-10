<?php

namespace App\Http\Controllers;


use App\Models\WorkCenter;
use Illuminate\Http\JsonResponse;

class WorkCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $workCenters = WorkCenter::all();

        return response()->json([
            'data' => $workCenters
        ]);
    }

    public function show(WorkCenter $work_center): JsonResponse
    {
        return response()->json([
            'data' => $work_center
        ]);
    }
}
