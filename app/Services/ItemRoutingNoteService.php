<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ItemRoutingNoteDTO;
use App\Models\ItemRouting;
use App\Models\ItemRoutingNote;

class ItemRoutingNoteService
{
    public function create(ItemRoutingNoteDTO $note, ItemRouting $itemRouting): ItemRoutingNote
    {
        $createdNote =  $itemRouting->notes()->create([
            'title' => $note->title,
            'value' => $note->value
        ]);

        return $createdNote;
    }

    public function update(ItemRoutingNote $itemRoutingNote, ItemRoutingNoteDTO $itemRoutingNoteDTO): ItemRoutingNote
    {

        return tap($itemRoutingNote, function ($note) use ($itemRoutingNoteDTO) {
            $note->update([
                'title' => $itemRoutingNoteDTO->title,
                'value' => $itemRoutingNoteDTO->value
            ]);
        });
    }
}
