<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
      'name' => ['required', 'max:255'],
      'email' => ['required','nullable', 'max:50', 'unique:customers,email,' . $this->route('customer')->id],
      'phone' => ['nullable', 'max:50'],
      'address' => ['nullable', 'max:150'],
      'city' => ['nullable', 'max:50'],
      'region' => ['nullable', 'max:50'],
      'country' => ['nullable', 'max:2'],
      'postal_code' => ['nullable', 'max:25'],
    ];
  }
}
