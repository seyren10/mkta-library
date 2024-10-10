<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemBom extends Model
{
    use HasFactory;

    public function material(): HasOne
    {
        return $this->hasOne(Material::class, "code", "material_code");
    }

    public function workCenter(): HasOne
    {
        return $this->hasOne(WorkCenter::class, 'abbr', 'work_center_abbr');
    }

    /**
     * Summary of scopeHasWorkCenter
     * @param string $workCenterAbbr
     * @return void
     */
    public function scopeFilterByWorkCenter(Builder $query, string $workCenterAbbr): void
    {
        $query->where('work_center_abbr', $workCenterAbbr);
    }
}
