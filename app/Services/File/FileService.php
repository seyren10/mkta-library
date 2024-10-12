<?php

declare(strict_types=1);

namespace App\Services\File;

use App\Enums\LibraryFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NoFilableRelationshipException;

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
        $cleanUrl = $this->cleanUrl($path);

        $this->files->add($cleanUrl);
        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function store(UploadedFile $uploadedFile, LibraryFolder $folder, mixed $appendedPath): string
    {
        $cleanUrl = $this->cleanUrl("{$folder->value}/{$appendedPath}");
        return $uploadedFile->store($cleanUrl);
    }

    /**
     * 
     *  Store and insert the record in the Database
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param \App\Enums\LibraryFolder $folder Main folder from which the file will be save
     * @param string $appendedPath usefull when you want to place the file on a subfolder base main $folder
     * @return FileService
     */

    public function storeAndAdd(UploadedFile $uploadedFile, LibraryFolder $folder, mixed $appendedPath): static
    {
        $file = $this->store($uploadedFile, $folder, $appendedPath);

        $this->addFile($file);

        return $this;
    }


    /**
     * Store and insert the record in the Database as Array
     * @param UploadedFile[] $uploadedFiles
     * @param \App\Enums\LibraryFolder $folder Main folder from which the file will be save
     * @param mixed $appendedPath usefull when you want to place the file on a subfolder base main $folder
     * @return static
     */
    public function storeAndAddMany(array $uploadedFiles, LibraryFolder $folder, mixed $appendedPath): static
    {
        foreach ($uploadedFiles as $file) {
            $this->storeAndAdd($file, $folder, $appendedPath);
        }

        return $this;
    }

    public function commit()
    {
        $this->checkModel();


        $this->model->files()->createMany($this->files->map(fn($file) => ['path' => $file]));
        $this->files = new Collection();
    }

    public function getFiles(): FileCollectionService
    {
        $this->checkModel();

        $files =  $this->model->files()
            ->pluck('path');
        return new FileCollectionService($files);
    }

    private function checkModel(): void
    {
        if ($this->model === null || !method_exists(get_class($this->model), 'files')) {

            if ($this->model === null) {
                throw new NoFilableRelationshipException('No Model provided');
            }

            $class = get_class($this->model);
            throw new NoFilableRelationshipException("there's no model provided or No files() relationship defined on class \"{$class}\"");
        }
    }

    private function cleanUrl($url)
    {
        return  preg_replace('#(?<!:)//+#', '/', $url);
    }
}
