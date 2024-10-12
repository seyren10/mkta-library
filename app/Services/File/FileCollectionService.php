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
        $this->files = $this->files->filter(fn($path) =>  explode('/', $path)[0] === $folder->value);

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
        $defaultDisk = config('filesystems.default');
        return $this->get()->map(fn($path) => config("filesystems.disks.{$defaultDisk}.url") . '/' . $path);
    }
}
