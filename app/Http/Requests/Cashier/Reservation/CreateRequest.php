<?php

namespace App\Http\Requests\Cashier\Reservation;

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
            'name' => 'required|string',
            'phone' => 'required',
            'date' => 'required|date_format:Y-m-d H:i',
            'table_id' => 'required|exists:tables,id',
            'amount' => 'integer',
        ];
    }
}
