<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('mysqlerp.llx_user')->ignore($user->rowid, 'rowid')],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'identification' => ['required', 'string'],
            'phone' => ['nullable', 'regex:/^\(\d{3}\)-\d{3}-\d{4}$/i'],
            'type' => ['required', 'exists:mysqlerp.llx_categorie,rowid']
        ])->validateWithBag('updateProfileInformation');
            
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'lastname' => $input['lastname'],
                'firstname' => $input['firstname'],
                'user_mobile' => $input['phone'] ?? '',
                'email' => $input['email']
            ])->save();
            
            $name_soc = $input['firstname'].' '.$input['lastname'];
            if (isset($input['company'])) {
                $name_soc .= ' ('.$input['company'].')';
            }
            
            $user->society->forceFill([
                'nom' => $name_soc,
                'phone' => $input['phone'] ?? '',
                'email' => $input['email'],
                'siren' => $input['identification'],  // RIF
            ])->save();

            $user->society->categories()->sync([$input['type']]);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'lastname' => $input['lastname'],
            'firstname' => $input['firstname'],
            'user_mobile' => $input['phone'] ?? '',
            'email' => $input['email']
        ])->save();

        $name_soc = $input['firstname'].' '.$input['lastname'];
        if (isset($input['company'])) {
            $name_soc .= ' ('.$input['company'].')';
        }

        $user->society->forceFill([
            'nom' => $name_soc,
            'phone' => $input['phone'] ?? '',
            'email' => $input['email'],
            'siren' => $input['identification'],  // RIF
        ])->save();

        $user->society->categories()->sync([$input['type']]);

        $user->sendEmailVerificationNotification();
    }
}
