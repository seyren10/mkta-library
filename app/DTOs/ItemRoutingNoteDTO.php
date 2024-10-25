<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Traits\Eloquentable;

class ItemRoutingNoteDTO
{
    use Eloquentable;
    
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $value = null,
        public readonly ?string $routingDetails = null
    ) {}
}
