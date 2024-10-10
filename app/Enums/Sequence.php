<?php

declare(strict_types=1);

namespace App\Enums;

enum Sequence: int
{
    case NEXT = 1;
    case PREVIOUS = -1;
}
