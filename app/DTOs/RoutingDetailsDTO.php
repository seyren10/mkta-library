<?php

namespace App\DTOs;

use App\Models\ItemRouting;
use App\Models\ItemRoutingNote;

class RoutingDetailsDTO
{
    public function __construct(
        public readonly ?string $routingNo = null,
        public readonly ?string $workCenterAbbr = null,
        public readonly ?int $sequenceIndex = null
    ) {}

    public function getRaw(): string|null
    {
        if ($this->routingNo === null || !$this->workCenterAbbr === null || !$this->sequenceIndex === null) return null;
        return $this->routingNo . ItemRoutingNote::Separator . $this->workCenterAbbr . ItemRoutingNote::Separator . $this->sequenceIndex;
    }
}