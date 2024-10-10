<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
