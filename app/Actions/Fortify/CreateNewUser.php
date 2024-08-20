<?php

namespace App\Actions\Fortify;

use App\Models\{Category, User, Society};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  /**
   * Validate and create a newly registered user.
   *
   * @param  array  $input
   * @return \App\Models\User
   */
  public function create(array $input)
  {
    Validator::make($input, [
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'company' => ['nullable', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:mysqlerp.llx_user'],
      'password' => $this->passwordRules(),
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
      'identification' => ['required', 'string', 'unique:mysqlerp.llx_societe,siren'],
      'phone' => ['nullable'],  // , 'regex:/^\(\d{3}\)-\d{3}-\d{4}$/i'
      'type' => ['required', 'exists:mysqlerp.llx_categorie,rowid']
    ])->validate();

    $user = User::create([
      'datec' => date('Y-m-d H:i:s'),
      'login' => $input['email'],
      'pass_crypted' => Hash::make($input['password']),
      'gender' => $input['gender'] ?? 'O',
      'lastname' => $input['last_name'],
      'firstname' => $input['first_name'],
      'fk_country' => 232,                  // 232 = Venezuela
      'user_mobile' => $input['phone'],
      'email' => $input['email']
    ]);

    $name_soc = $input['first_name'].' '.$input['last_name'];
    if (isset($input['company'])) {
      $name_soc .= ' ('.$input['company'].')';
    }

    $society = Society::create([
      'nom' => $name_soc,
      'fk_pays' => 232,                     // 232 = Venezuela
      'phone' => $input['phone'],
      'email' => $input['email'],
      'fk_typent' => 0,                     // Tipo de empresa
      'siren' => $input['identification'],  // RIF
      'client' => 2,                        // 2 = Cliente Potencial
      'price_level' => 2,                   // Nivel de Precio inicial del Cliente (Lista de Precios 2)
      'datec' => date('Y-m-d H:i:s'),
      'fk_user_creat' => $user->rowid,
      'fk_user_modif' => $user->rowid,
      'fk_multicurrency' => 1,
      'multicurrency_code' => 'USD'
    ]);

    $user->fk_soc = $society->rowid;
    $user->save();

    $society->categories()->attach($input['type']);

    return $user;
  }
}
