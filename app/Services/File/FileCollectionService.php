<?php

declare(strict_types=1);

namespace App\Services\File;



class FileCollectionService
{
    public static function toUrl($path)
    {
        $defaultDisk = config('filesystems.default');
        return  config("filesystems.disks.{$defaultDisk}.url") . '/' . $path;
    }
}
