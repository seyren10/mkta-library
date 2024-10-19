<?php

declare(strict_types=1);

namespace App\Services\File;

use Illuminate\Support\Str;
use App\Enums\LibraryFolder;
use Illuminate\Support\Collection;

class FileCollectionService
{
    public function __construct(private Collection $files) {}

    public function fromFolder(LibraryFolder $folder): static
    {
        $this->files = $this->files->filter(callback: fn($file) =>  $file['file_type'] === $folder);

        return $this;
    }

    public function byExtension(string|array $extensions): static
    {
        $this->files =  $this->files->filter(fn($path) => Str::endsWith($path, $extensions));

        return $this;
    }

    public function get(): Collection
    {
        return $this->files->values();
    }

    public function getAsUrl()
    {
        return $this->get()->map(fn($file) => self::toUrl($file['path']));
    }

    public static function toUrl($path)
    {
        $defaultDisk = config('filesystems.default');
        return  config("filesystems.disks.{$defaultDisk}.url") . '/' . $path;
    }
}
