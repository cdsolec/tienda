<?php

namespace App\Http\Requests\Brands;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Image;

class AdminUpdateBrandRequest extends FormRequest
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
      'name'=> ['required','string'],
      'image' => ['nullable','image']
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
      'image.image' => 'La Imagen es inválida'
    ];
  }

  public function updateBrand(Brand $brand)
  {
    $old_image = $brand->image;

    if($this->hasFile('image')) {
      $fileImage = $this->file('image');
      $path = $fileImage->path();
      $extension = $fileImage->extension();
      $imageName = $fileImage->getClientOriginalName();
      //FILE NAME WITHOUT EXTENSION
      $filename = pathinfo($imageName, PATHINFO_FILENAME);

      $i = 1;
      //ADD A NUMBER IF FILE EXISTS
      while(Storage::disk('public')->exists('brands/'.$imageName)) {
        $imageName = $filename.'_'.$i.'.'.$extension;
        $i++;
      }

      if (!file_exists('storage/brands/')) { mkdir('storage/brands', 0777, true); }

      $thumbnail = Image::make($fileImage);
      $thumbnail->fit(600);
      $thumbnail->save('storage/brands/'.$imageName);

      if(Storage::disk('public')->exists('brands/'.$old_image)) {
        Storage::disk('public')->delete('brands/'.$old_image);
      }
    } else {
      $imageName = $old_image;
    }

    $brand->fill([
      'name' => $this->name,
      'image' => $imageName ?? null
    ]);

    $brand->save();
  }
}
