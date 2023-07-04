<?php

namespace App\Http\Requests\Cashier\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
          'phone' => 'required|min:10|max:13',
          'date' => 'required',
          'table_id' => 'required|exists:tables,id',
          'amount' => 'integer',
          'rekening' => 'integer',
          'payment_method' => 'required|string'
        ];
    }
}
