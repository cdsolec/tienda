<?php

namespace App\Http\Requests\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCreateSettingRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name'=> 'required|string|unique:settings',
      'value' => 'required|numeric'
    ];
  }

  /**
   * Get the validation messages that apply to the request.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'name.required' => 'El Nombre es obligatorio',
      'name.string' => 'El Nombre es inválido',
      'name.unique' => 'El Nombre debe ser único',
      'value.required' => 'El Valor es obligatorio',
      'value.numeric' => 'El Valor es inválido'
    ];
  }

  public function createSetting()
  {
    $setting = Setting::create([
      "name" => $this->name,
      "value" => $this->value
    ]);
  }
}
