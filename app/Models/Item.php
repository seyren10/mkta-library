<?php

namespace App\Models;

use App\Enums\LibraryFolder;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $hidden = [
        'routing_no',
        'production_bom_no'
    ];

    public function dimension(): HasOne
    {
        return $this->hasOne(ItemDimension::class, 'item_code', 'code');
    }

    public function itemBoms(): HasMany
    {
        return $this->hasMany(ItemBom::class, 'production_bom_no', 'production_bom_no');
    }

    public function itemRoutings(): HasMany
    {
        return $this->hasMany(ItemRouting::class, 'routing_no', 'routing_no')->orderBy('sequence_index');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(LibraryFile::class, 'filable', 'filable_type', 'filable_id', 'code');
    }
}
