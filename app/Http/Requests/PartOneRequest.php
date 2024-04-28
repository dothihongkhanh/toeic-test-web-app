<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartOneRequest extends FormRequest
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
            'name_practice' => [
                'required',
                'between:6,255',
            ],
            'price' => [
                'required',
            ],
            'file_upload' => [
                'required',
                'file',
                'mimes:xls,xlsx',
            ],
            'audio_upload' => [
                'required',
            ],
            'image_upload' => [
                'required',                
            ],
        ];
    }
}
