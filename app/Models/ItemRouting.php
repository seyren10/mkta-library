<?php

namespace App\Models;

use App\Enums\Sequence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ItemRouting extends Model
{
    use HasFactory;

    public function workCenter(): HasOne
    {
        return $this->hasOne(WorkCenter::class, "abbr", "work_center_abbr");
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, "routing_no", "routing_no");
    }

    public function files(): MorphMany
    {
        return $this->morphMany(LibraryFile::class, 'filable');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ItemRoutingNote::class, 'routing_no', 'id');
    }

    /**
     * Get the instance of ItemRouting by its sequence_index field
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $sequenceIndex current sequence index to base on
     * @param Sequence $direction direction from which determines where to offset the current sequence index. +1 for next, -1 for previous
     * @return void
     */
    public function scopeSequence(Builder $query, int $sequenceIndex, Sequence $direction)
    {
        $query->where('sequence_index',  $sequenceIndex + $direction->value);
    }
}
