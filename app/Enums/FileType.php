<?php

declare(strict_types=1);

namespace App\Enums;

enum FileType: string
{
    case Images = 'images';
    case Files = 'files';
    case WorkCenters = 'work_centers';
}
