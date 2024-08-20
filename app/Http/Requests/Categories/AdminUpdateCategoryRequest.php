<?php

namespace App\Http\Requests\Categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateCategoryRequest extends FormRequest
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
      'name'=> ['required', 'string', Rule::unique('categories')->ignore($this->route('category'))]
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
      'name.required' => 'El Nombre es requerido',
      'name.unique' => 'El Nombre debe de ser único'
    ];
  }

  public function updateCategory(Category $category)
  {
    $category->fill([
      'name' => $this->name
    ]);

    $category->save();
  }
}
