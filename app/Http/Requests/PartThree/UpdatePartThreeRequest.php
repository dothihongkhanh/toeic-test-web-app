<?php

namespace App\Http\Requests\PartThree;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartThreeRequest extends FormRequest
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
            'question_title.*' => 'required|string',
            'answers.*' => 'required|string',
            'correct_answer.*' => 'required|exists:answers,id',
            'explanation.*' => 'required|string',
        ];
    }
}
