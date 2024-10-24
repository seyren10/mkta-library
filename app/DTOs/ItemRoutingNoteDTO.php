<?php

declare(strict_types=1);

namespace App\DTOs;

class ItemRoutingNoteDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $value = null,
        public readonly ?RoutingDetailsDTO $routingDetails = null
    ) {}
}
