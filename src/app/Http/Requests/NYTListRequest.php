<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NYTListRequest extends FormRequest
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
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'regex:/^\d{10}(\d{3})?$/'],
            'title' => ['nullable', 'string', 'max:255'],
            'offset' => ['nullable', 'integer', 'min:0', 'multiple_of:20'],
        ];
    }
}
