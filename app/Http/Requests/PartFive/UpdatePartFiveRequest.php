<?php

namespace App\Http\Requests\PartFive;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartFiveRequest extends FormRequest
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
            'question_title.*' => 'required|string|max:255',
            'explanation.*' => 'required|string|max:1000',
            'answers.*' => 'required|string|max:255',
            'correct_answer.*' => 'required|integer',
        ];
    }
}
