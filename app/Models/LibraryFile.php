<?php

namespace App\Models;

use App\Enums\FileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

class LibraryFile extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'file_type', 'name'];

    protected function casts(): array
    {
        return [
            'file_type' => FileType::class
        ];
    }
    public function filable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeOnFolder(Builder $query, FileType $folder)
    {
        $query->where('file_type', $folder);
    }
}
