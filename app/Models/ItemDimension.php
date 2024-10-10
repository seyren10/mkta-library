<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'length',
        'width',
        'height',
        'sqm',
        's_weight'
    ];
}
