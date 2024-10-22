<?php

declare(strict_types=1);

namespace App\DTOs;

class ItemRoutingNoteDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $value,
    ) {}
}
