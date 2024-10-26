<?php

declare(strict_types=1);

namespace App\Services\File;

use App\DTOs\RoutingDetailsDTO;
use App\Enums\FileType;
use App\Models\LibraryFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\NoFilableRelationshipException;
use App\Models\ItemRouting;
use App\Services\ItemRoutingNoteService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FileService
{
    private Collection $files;
    private ?Model $model = null;

    public function __construct()
    {
        $this->files = new Collection();
    }


    public function addFile(string $path, FileType $fileType, string $name): static
    {
        $cleanUrl = $this->cleanUrl($path);

        $this->files->add([
            'path' => $cleanUrl,
            'fileType' => $fileType,
            'name' => $name
        ]);

        return $this;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function store(UploadedFile $uploadedFile, mixed $path): string
    {
        $cleanUrl = $this->cleanUrl($path);
        return $uploadedFile->store($cleanUrl);
    }

    /**
     * 
     *  Store and insert the record in the Database
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param \App\Enums\FileType $folder Main folder from which the file will be save
     * @param string $path usefull when you want to place the file main $folder
     * @return FileService
     */

    public function storeAndAdd(UploadedFile $uploadedFile, FileType $fileType, mixed $path): static
    {
        $file = $this->store($uploadedFile, $path);
        $name = $uploadedFile->getClientOriginalPath();
        $this->addFile($file, $fileType, $name);

        return $this;
    }


    /**
     * Store and insert the record in the Database as Array
     * @param UploadedFile[] $uploadedFiles
     * @param \App\Enums\FileType $folder Main folder from which the file will be save
     * @param mixed $path usefull when you want to place the file main $folder
     * @return static
     */
    public function storeAndAddMany(array $uploadedFiles, FileType $fileType, mixed $path): static
    {
        foreach ($uploadedFiles as $file) {
            $this->storeAndAdd($file, $fileType, $path);
        }

        return $this;
    }

    public function commit()
    {
        $this->checkModel();

        $this->model->files()->createMany($this->files
            ->map(fn($file) => ['path' => $file['path'], 'file_type' => $file['fileType'], 'name' => $file['name']]));
        $this->files = new Collection();
    }
    public function customCommit(ItemRouting $itemRouting)
    {
        $this->checkModel();


        $routingDetails = new RoutingDetailsDTO($itemRouting->routing_no, $itemRouting->work_center_abbr, $itemRouting->process_index);
        $routingDetails = $routingDetails->getRaw();

        $this->files->each(function ($file) use ($routingDetails) {
            $fileModel =  new LibraryFile([
                'path' => $file['path'],
                'file_type' => $file['fileType'],
                'name' => $file['name']
            ]);

            $fileModel->filable_type = $this->model::class;
            $fileModel->filable_id = $routingDetails;
            
            $fileModel->save();
        });


        // $this->model->files()->createMany($this->files
        //     ->map(function ($file) use ($itemRouting) {
        //         $filableId = $routingDetails->getRaw();
        //         info($filableId);
        //         return ['path' => $file['path'], 'file_type' => $file['fileType'], 'name' => $file['name'], 'filable_id' => $filableId];
        //     }));
        $this->files = new Collection();
    }

    public function getFiles(FileType $fileType = null): Collection
    {
        $this->checkModel();

        return  $this->model
            ->files()
            ->when($fileType, fn($query) => $query->where('file_type', $fileType))
            ->get();
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
