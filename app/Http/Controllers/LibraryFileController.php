<?php

namespace App\Http\Controllers;

use App\Enums\LibraryFolder;
use App\Models\Item;
use App\Services\File\FileService;
use App\Http\Requests\UploadImagesRequest;
use App\Http\Requests\UploadDocumentsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LibraryFileController extends Controller
{
    public function __construct(private FileService $fileService) {}

    public function getDocuments(Item $item): JsonResponse
    {
        $files =  $this->fileService
            ->setModel($item)
            ->getFiles(LibraryFolder::FILES)
            ->getAsUrl();

        return response()->json($files);
    }
    public function uploadDocuments(UploadDocumentsRequest $request, Item $item): Response
    {
        $validated = $request->validated();
        $files = $validated['docs'];

        $this->fileService
            ->storeAndAddMany($files, LibraryFolder::FILES, $item->code)
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }

    public function getImages(Item $item): JsonResponse
    {
        $images =  $this->fileService
            ->setModel($item)
            ->getFiles(LibraryFolder::IMAGES)
            ->getAsUrl();

        return response()->json($images);
    }

    public function uploadImages(UploadImagesRequest $request, Item $item): Response
    {
        $validated = $request->validated();
        $files = $validated['images'];

        $this->fileService
            ->storeAndAddMany($files, LibraryFolder::IMAGES, $item->code)
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }
}
