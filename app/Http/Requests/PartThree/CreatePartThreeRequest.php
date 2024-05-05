<?php

namespace App\Http\Requests\PartThree;

use App\Rules\MultipleFiles;
use Illuminate\Foundation\Http\FormRequest;

class CreatePartThreeRequest extends FormRequest
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
                'unique:exams,name_exam',
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
                new MultipleFiles(13),
            ],
            'image_upload' => [
                'required',
                new MultipleFiles(3),
            ],
        ];
    }
}
