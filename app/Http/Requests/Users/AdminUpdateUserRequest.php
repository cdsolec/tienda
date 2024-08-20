<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AdminUpdateUserRequest extends FormRequest
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
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->route('user'))],
      'identification' => ['required', 'string', Rule::unique('users')->ignore($this->route('user'))],
      'gender' => ['required', 'in:M,F,O'],
      'phone' => ['nullable', 'regex:/^\(\d{3}\)-\d{3}-\d{4}$/i'],
      'license' => ['nullable', 'in:"Segundo Grado (2da)","Tercer Grado (3era)","Cuarto Grado (4ta)","Quinto Grado (5ta)"'],
      'medical_certificate_date' => ['nullable', 'date_format:d/m/Y'],
      'medical_certificate_expiration' => ['nullable', 'date_format:d/m/Y'],
      'role' => 'required|exists:bouncer_roles,name'
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
      'first_name.required' => 'Nombre es requerido',
      'last_name.required' => 'Apellido es requerido',
      'email.required' => 'Email es requerido',
      'email.email' => 'Email inválido',
      'identification.required' => 'Identificación es requerida',
      'identification.unique' => 'Identificación inválido',
      'gender.required' => 'Sexo es requerido',
      'gender.in' => 'Sexo es inválido',
      'phone.regex' => 'Teléfono es inválido. Ejem.:(243)-234-5678',
      'licenser.in' => 'Licencia inválida',
      'medical_certificate_date.date_format' => 'Fecha Certificado Médico inválida',
      'medical_certificate_expiration.date_format' => 'Expiración Certificado Médico inválida',
      'role.required' => 'Rol es requerido',
      'role.required' => 'Rol es requerido',
      'role.exists' => 'Rol inválido'
    ];
  }

  public function updateProfile(User $user)
  {
    if (empty($this->medical_certificate_date)) {
      $medical_certificate_date = null;
    } else {
      $medical_certificate_date = Carbon::createFromFormat('d/m/Y', $this->medical_certificate_date);
    }

    if (empty($this->medical_certificate_expiration)) {
      $medical_certificate_expiration = null;
    } else {
      $medical_certificate_expiration = Carbon::createFromFormat('d/m/Y', $this->medical_certificate_expiration);
    }

    $user->fill([
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'email' => $this->email,
      'identification' => $this->identification,
      'gender' => $this->gender,
      'phone' => $this->phone ?? null,
      'license' => $this->license ?? null,
      'medical_certificate_date' => $medical_certificate_date,
      'medical_certificate_expiration' => $medical_certificate_expiration
    ]);

    $user->save();

    Bouncer::sync($user)->roles([]);
    $user->assign($this->role);
  }
}
