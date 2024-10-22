<?php

namespace App\Http\Controllers;

use App\Models\ItemRouting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ItemRoutingNote;
use App\DTOs\ItemRoutingNoteDTO;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\ItemRoutingNoteService;
use Illuminate\Support\Facades\Validator;

class ItemRoutingController extends Controller
{
    public function __construct(protected ItemRoutingNoteService $itemRoutingNoteService) {}
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

    public function storeNote(StoreNoteRequest $request, ItemRouting $item_routing): JsonResponse
    {
        $validated = $request->validated();

        $note = new ItemRoutingNoteDTO($validated['title'], $validated['value']);
        $createdNote = $this->itemRoutingNoteService->create($note, $item_routing);

        return response()->json([
            'data' => $createdNote
        ]);
    }
    public function updateNote(UpdateNoteRequest $request, ItemRoutingNote $note): JsonResponse
    {
        $validated = $request->validated();

        $noteDTO = new ItemRoutingNoteDTO($validated['title'], $validated['value']);

        $updatedNote = $this->itemRoutingNoteService->update($note, $noteDTO);
        return response()->json([
            'data' => $updatedNote
        ]);
    }
    public function destroyNote(UpdateNoteRequest $request, ItemRoutingNote $note): Response
    {
        $note->delete();

        return response()->noContent();
    }
}
