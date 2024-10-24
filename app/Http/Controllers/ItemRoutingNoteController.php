<?php

namespace App\Http\Controllers;

use App\DTOs\RoutingDetailsDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ItemRoutingNote;
use App\DTOs\ItemRoutingNoteDTO;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\ItemRoutingNoteService;

class ItemRoutingNoteController extends Controller
{

    public function __construct(protected ItemRoutingNoteService $itemRoutingNoteService) {}

    public function show(Request $request, ItemRoutingNote $note)
    {
        return response()->json(
            [
                'data' => $note
            ]
        );
    }

    public function store(StoreNoteRequest $request)
    {
        $validated = $request->validated();

        $routingDetails = new RoutingDetailsDTO(
            $validated['routing_no'],
            $validated['work_center_abbr'],
            $validated['sequence_index']
        );

        $note = new ItemRoutingNoteDTO($validated['title'], $validated['value'], $routingDetails);

        $createdNote = $this->itemRoutingNoteService->create($note);

        return response()->json([
            'data' => $createdNote
        ]);
    }
    public function update(UpdateNoteRequest $request, ItemRoutingNote $note): JsonResponse
    {
        $validated = $request->validated();

        $noteDTO = new ItemRoutingNoteDTO($validated['title'], $validated['value']);

        $updatedNote = $this->itemRoutingNoteService->update($note, $noteDTO);

        return response()->json([
            'data' => $updatedNote
        ]);
    }
    public function destroy(UpdateNoteRequest $request, ItemRoutingNote $note): Response
    {
        $note->delete();

        return response()->noContent();
    }
}
