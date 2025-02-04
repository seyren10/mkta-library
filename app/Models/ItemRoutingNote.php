<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRoutingNote extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'value',
        'routing_details'
    ];

    public const Separator = '@';
}
