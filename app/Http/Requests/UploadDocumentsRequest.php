<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadDocumentsRequest extends FormRequest
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
            'docs' => ['required'],
            'docs.*' => [
                File::types(['jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'csv', 'mp4'])
                    ->max(config('filesystems.disks.library.max_upload_size'))
            ]
        ];
    }
}
