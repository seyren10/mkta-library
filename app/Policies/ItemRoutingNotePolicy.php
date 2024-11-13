<?php

namespace App\Policies;

use App\Models\ItemRoutingNote;
use App\Models\User;

class ItemRoutingNotePolicy
{


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-note');
    }

    public function update(User $user, ItemRoutingNote $itemRoutingNote)
    {
        return $user->hasPermissionTo('edit-note');
    }

    public function destroy(User $user)
    {
        return $user->hasPermissionTo('delete-note');
    }
}
