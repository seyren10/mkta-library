<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\ItemRouting;
use App\Services\ItemRoutingNoteService;
use Illuminate\Validation\Validator;


class MustBeValidRoutingDetailsValidator
{
    public function __invoke(Validator $validator)
    {
        $attributes = $validator->attributes();


        $routing = ItemRouting::where('routing_no', $attributes['routing_no'])
            ->where('work_center_abbr', $attributes['work_center_abbr'])
            ->where('sequence_index', $attributes['sequence_index'])->first();

        if ($routing === null) {
            $validator->errors()->addIf($routing === null, 'routing_details', 'Routing Details are Invalid');
        }
    }
}
