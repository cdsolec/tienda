<?php

namespace App\Http\Requests\Banners;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminCreateBannerRequest extends FormRequest
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
      'image' => 'required|image'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Nombre es requerido',
      'image.required' => 'Imagen es requerida',
      'image.image' => 'Imagen inválida'
    ];
  }

  public function createBanner() 
  {
    $imageName = null;
    if($this->hasFile('image')) {
      $fileImage = $this->file('image');
      $path = $fileImage->path();
      $extension = $fileImage->extension();
      $imageName = $fileImage->getClientOriginalName();
      // FILE NAME WITHOUT EXTENSION
      $filename = pathinfo($imageName, PATHINFO_FILENAME);

      // CREATES DIRECTORY
      if(!Storage::disk('public')->exists('banners')) {
        Storage::disk('public')->makeDirectory('banners');
      }

      $i = 1;
      // ADD A NUMBER IF FILE EXISTS
      while(Storage::disk('public')->exists('banners/'.$imageName)) {
        $imageName = $filename.'_'.$i.'.'.$extension;
        $i++;
      }

      $thumbnail = Image::make($fileImage)->resize(1200, 400);
      
      Storage::disk('public')->put('banners/'.$imageName, $thumbnail->stream());
    }

    $banner = Banner::create([
      'name' => $this->name,
      'image' => $imageName
    ]);
  }
}