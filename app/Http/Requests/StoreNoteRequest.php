<?php

namespace App\Http\Requests;

use App\Rules\MustBeValidRoutingDetails;
use App\Rules\MustBeValidRoutingDetailsValidator;
use App\Rules\ValidateRoutingDetails;
use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'value' => 'required',
            'routing_details' => ['required', 'regex:/^[^@]+\\@[^@]+\\@[^@]+$/', new ValidateRoutingDetails]
        ];
    }
}
