<?php

namespace App\Http\Requests\Settings;

use App\Models\SocietyPeople;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateAddressRequest extends FormRequest
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
      'lastname'=> 'required|string',
      'address'=> 'required|string',
      'town'=> 'required|string',
      'departament'=> 'required|string',
      'phone'=> 'required|string',
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
      
    ];
  }

  public function updateSetting(SocietyPeople $address)
  {
    $address->fill([
      "lastname" => $this->lastname,
        "address" => $this->address,
        "fk_departement" => $this->departament,
        "town" => $this->town,
        "phone" => $this->phone
    ]);

    $address->save();
  }
}
