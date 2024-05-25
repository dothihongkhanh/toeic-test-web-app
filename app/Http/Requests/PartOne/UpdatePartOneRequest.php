<?php

namespace App\Http\Requests\PartOne;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartOneRequest extends FormRequest
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
            'audio' => 'file',
            'image' => 'image',
            'transcript.*' => 'required',
            'answers.*' => 'required|string',
            'correct_answer.*' => 'required|exists:answers,id',
            'explanation.*' => 'required|string',
        ];
    }
}
