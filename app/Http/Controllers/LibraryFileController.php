<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Enums\FileType;
use Illuminate\Http\Response;
use App\Services\File\FileService;
use App\Http\Requests\UploadImagesRequest;
use App\Http\Requests\UploadDocumentsRequest;
use App\Http\Requests\ItemRoutingUploadFilesRequest;
use App\Http\Resources\LibraryFilesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\UploadedFile;

class LibraryFileController extends Controller
{
    public function __construct(private FileService $fileService) {}

    public function getDocuments(Item $item): JsonResource
    {
        $files =  $this->fileService
            ->setModel($item)
            ->getFiles(FileType::Files);
        return LibraryFilesResource::collection($files);
    }
    public function uploadDocuments(UploadDocumentsRequest $request, Item $item): Response
    {
        $validated = $request->validated();
        $files = $validated['docs'];


        /**
         * @var UploadedFile $file
         */

        $path = $item->code . '/' . FileType::Files->value;
        $this->fileService
            ->storeAndAddMany($files, FileType::Files, $path)
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }

    public function getImages(Item $item): JsonResource
    {
        $images =  $this->fileService
            ->setModel($item)
            ->getFiles(FileType::Images);


        return LibraryFilesResource::collection($images);
    }

    public function uploadImages(UploadImagesRequest $request, Item $item): Response
    {
        $validated = $request->validated();
        $files = $validated['images'];


        $path = $item->code . '/' . FileType::Images->value;
        $this->fileService
            ->storeAndAddMany($files, FileType::Images, $path)
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }

    public function itemRoutingUploadFiles(ItemRoutingUploadFilesRequest $request, Item $item, int|string $id): Response
    {
        $validated = $request->validated();
        $files = $validated['docs'];

        $routing = $item->itemRoutings()->findOrFail($id);

        /* determines where the files will be placed on the storage */
        $path = $item->code . '/' . FileType::WorkCenters->value . '/' . $routing->work_center_abbr . '_' . $routing->process_index;
        $this->fileService
            ->storeAndAddMany($files, FileType::WorkCenters, $path)
            ->setModel($routing)
            ->customCommit($routing);

        return response()->noContent();
    }
}
