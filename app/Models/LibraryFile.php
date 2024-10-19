<?php

namespace App\Models;

use App\Enums\LibraryFolder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

class LibraryFile extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'file_type'];

    protected function casts(): array
    {
        return [
            'file_type' => LibraryFolder::class
        ];
    }
    public function filable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeOnFolder(Builder $query, LibraryFolder $folder)
    {
        $query->where('file_type', $folder);
    }
}
