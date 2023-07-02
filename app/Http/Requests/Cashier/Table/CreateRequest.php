<?php

namespace App\Http\Requests\Cashier\Table;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tables,name',
            'is_paid' => 'required|boolean',
            'capacity' => 'required|integer|min:1',
            'price' => 'integer|min:0',
        ];
    }
}
