<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ItemRoutingNote;
use App\DTOs\ItemRoutingNoteDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('create', ItemRoutingNote::class);

        $validated = $request->validated();
        $note = new ItemRoutingNoteDTO($validated['title'], $validated['value'], $validated['routing_details']);

        $createdNote = $this->itemRoutingNoteService->create($note);

        return response()->json([
            'data' => $createdNote
        ]);
    }

    public function update(UpdateNoteRequest $request, ItemRoutingNote $note): JsonResponse
    {
        Gate::authorize('update', $note);


        $validated = $request->validated();


        $updatedNote = $this->itemRoutingNoteService->update(
            $note,
            new ItemRoutingNoteDTO($validated['title'] ?? null, $validated['value'] ?? null)
        );

        return response()->json([
            'data' => $updatedNote
        ]);
    }
    public function destroy(UpdateNoteRequest $request, ItemRoutingNote $note): Response
    {
        Gate::authorize('destroy', $note);

        $note->delete();

        return response()->noContent();
    }
}
