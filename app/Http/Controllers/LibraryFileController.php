<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadDocumentsRequest;
use App\Http\Requests\UploadImagesRequest;
use App\Models\Item;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;

class LibraryFileController extends Controller
{
    public function __construct(private FileService $fileService) {}
    public function uploadDocuments(UploadDocumentsRequest $request, Item $item)
    {

        $validated = $request->validated();

        $files = $validated['docs'];
        /**
         * @var UploadedFile[] $files
         */
        foreach ($files as $file) {
            $uploaded = $file->store("files/{$item->code}");
            $this->fileService->addFile($uploaded);
        }


        $this->fileService
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }

    public function uploadImages(UploadImagesRequest $request, Item $item)
    {
        $validated = $request->validated();
        $files = $validated['images'];

        /**
         * @var UploadedFile $file
         */
        foreach ($files as $file) {
            $this->fileService->addFile($file->store("images/{$item->code}"));
        }

        $this->fileService
            ->setModel($item)
            ->commit();

        return response()->noContent();
    }
}
