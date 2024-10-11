<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadDocumentsRequest;
use App\Http\Requests\UploadImagesRequest;
use App\Models\Item;
use Illuminate\Http\UploadedFile;

class LibraryFileController extends Controller
{
    public function uploadDocuments(UploadDocumentsRequest $request, Item $item)
    {

        $validated = $request->validated();
        $files = $validated['docs'];

        /**
         * @var UploadedFile $file
         */
        foreach ($files as $file) {
            $file->store("files/{$item->code}");
        }
    }

    public function uploadImages(UploadImagesRequest $request, Item $item)
    {
        $validated = $request->validated();
        $files = $validated['images'];

        /**
         * @var UploadedFile $file
         */
        foreach ($files as $file) {
            $file->store("images/{$item->code}");
        }
    }
}
