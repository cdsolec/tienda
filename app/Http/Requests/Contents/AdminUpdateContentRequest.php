<?php

namespace App\Http\Requests\Contents;

use App\Models\Content;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateContentRequest extends FormRequest
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
      'name' => 'required|string',
      'description' => 'required|string'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Nombre es requerido',
      'description.required' => 'Descripción es requerida'
    ];
  }

  public function updateContent(Content $content) 
  {    
    $content->fill([
      'name' => $this->name,
      'description' => $this->description,
    ]);

    $content->save();
  }
}