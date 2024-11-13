<?php

namespace App\Policies;

use App\Models\LibraryFile;
use App\Models\User;

class LibraryFilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function uploadDocuments(User $user)
    {
        return $user->hasPermissionTo('upload-supporting-documents');
    }

    public function deleteDocument(User $user)
    {
        return $user->hasPermissionTo('delete-supporting-documents');
    }

    public function uploadImages(User $user)
    {
        return $user->hasPermissionTo('upload-images');
    }
    public function deleteImage(User $user)
    {
        return $user->hasPermissionTo('delete-image');
    }
    public function uploadAttachments(User $user)
    {
        return $user->hasPermissionTo('upload-attachments');
    }
    public function deleteAttachment(User $user)
    {
        return $user->hasPermissionTo('delete-attachments');
    }
}
