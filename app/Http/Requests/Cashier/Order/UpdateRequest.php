<?php

namespace App\Http\Requests\Cashier\Order;

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
      'table_id' => 'required|exists:tables,id',
      'menu_id' => 'required|array',
      'menu_id.*' => 'integer|exists:menus,id',
      'amount' => 'required|array',
      'amount.*' => 'integer',
      'is_paid' => 'required|boolean',
      'nominal' => 'integer',
      'rekening' => 'integer',
      'payment_method' => 'required|string'
    ];
  }
}
