<?php

namespace App\Rules;

use App\Models\ItemRouting;
use App\Services\ItemRoutingNoteService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateRoutingDetails implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $noteRoutingDetails = (new ItemRoutingNoteService)->getRoutingDetailData($value);
        $routing = ItemRouting::where('routing_no', $noteRoutingDetails->routingNo)
            ->where('work_center_abbr', $noteRoutingDetails->workCenterAbbr)
            ->where('sequence_index', $noteRoutingDetails->sequenceIndex)
            ->first();


        if (!$routing)
            $fail("The {$attribute} cannot be found");
    }
}
