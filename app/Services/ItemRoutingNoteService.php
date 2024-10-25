<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ItemRoutingNoteDTO;
use App\DTOs\RoutingDetailsDTO;
use App\Models\ItemRouting;
use App\Models\ItemRoutingNote;

class ItemRoutingNoteService
{

    public function getRoutingDetailData(string $routingDetails)
    {
        [$routingNo, $workCenterAbbr, $sequenceIndex] = explode('@', $routingDetails);

        return new RoutingDetailsDTO($routingNo, $workCenterAbbr, +$sequenceIndex);
    }
    public function create(ItemRoutingNoteDTO $note): ItemRoutingNote
    {
        $createdNote =  ItemRoutingNote::create($note->eloquentValues());

        return $createdNote;
    }

    public function update(ItemRoutingNote $itemRoutingNote, ItemRoutingNoteDTO $itemRoutingNoteDTO): ItemRoutingNote
    {

        return tap($itemRoutingNote, function ($note) use ($itemRoutingNoteDTO) {
            $note->update($itemRoutingNoteDTO->eloquentValues());
        });
    }
}
