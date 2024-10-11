<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NoFilableRelationshipException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

class FileService
{
    private Collection $files;
    private ?Model $model = null;

    public function __construct()
    {
        $this->files = new Collection();
    }


    public function addFile(string $path): static
    {
        $this->files->add($path);
        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function commit()
    {
        if ($this->model !== null && method_exists(get_class($this->model), 'files')) {

            $this->model->files()->createMany($this->files->map(fn($file) => ['path' => $file]));
            $this->files = new Collection();
        } else {
            $class = get_class($this->model);
            throw new NoFilableRelationshipException("there's no model provided or No files() relationship defined on class \"{$class}\"");
        }
    }
}
