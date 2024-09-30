<?php

namespace App\Http\Requests\Settings;

use App\Models\SocietyPeople;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class AdminCreateAddressRequest extends FormRequest
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

  public function createAddress()
  {

    

    $address = SocietyPeople::create([
        "datec"=>now(),
        "fk_soc" => Auth::user()->society->rowid,
        "fk_pays" => '232',
        "fk_user_creat" => Auth::user()->rowid,
        "lastname" => $this->lastname,
        "address" => $this->address,
        "fk_departement" => $this->departament,
        "town" => $this->town,
        "phone" => $this->phone
    ]);
  }
}
