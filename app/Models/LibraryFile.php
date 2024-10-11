<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LibraryFile extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function filable(): MorphTo
    {
        return $this->morphTo();
    }
}
