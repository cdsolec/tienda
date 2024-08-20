<x-guest-layout>
  <x-jet-authentication-card width="big">
    <x-slot name="logo">
      <x-jet-authentication-card-logo />
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="grid gap-3 grid-cols-1 md:grid-cols-2">
        <div class="mt-4">
          <x-jet-label for="first_name" value="{{ __('auth.First_Name') }}" />
          <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" placeholder="Nombre" required autofocus autocomplete="first_name" />
        </div>

        <div class="mt-4">
          <x-jet-label for="last_name" value="{{ __('auth.Last_Name') }}" />
          <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" placeholder="Apellido" required />
        </div>

        <div class="mt-4">
          <x-jet-label for="company" value="{{ __('auth.Company') }}" />
          <x-jet-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')" placeholder="Empresa C.A." />
        </div>

        <div class="mt-4">
          <x-jet-label for="identification" value="{{ __('auth.Identification') }}" />
          <x-jet-input id="identification" class="block mt-1 w-full" type="text" name="identification" :value="old('identification')" placeholder="Ej: V12345678 / J504099929" required />
        </div>

        {{-- <div class="mt-4">
          <div class="block font-medium text-sm text-gray-700 mb-2">{{ __('auth.Gender') }}</div>
          <label for="male" class="inline-flex items-center cursor-pointer mb-2">
            <x-forms.radio id="male" name="gender" value="M" />
            <span class="ml-2 text-sm font-semibold text-gray-800">{{ __('auth.Male') }}</span>
          </label>
          <label for="female" class="inline-flex items-center cursor-pointer mb-2">
            <x-forms.radio id="female" name="gender" value="F" />
            <span class="ml-2 text-sm font-semibold text-gray-800">{{ __('auth.Female') }}</span>
          </label>
          <label for="other" class="inline-flex items-center cursor-pointer mb-2">
            <x-forms.radio id="other" name="gender" value="O" />
            <span class="ml-2 text-sm font-semibold text-gray-800">{{ __('auth.Other') }}</span>
          </label>
          <x-jet-input-error for="gender" class="mt-2" />
        </div> --}}

        <div class="mt-4">
          <x-jet-label for="email" value="{{ __('auth.Email') }}" />
          <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="nombre@email.com" required />
        </div>

        <div class="mt-4">
          <label for="phone" class="block font-medium text-sm text-gray-700">
            {{ __('auth.Phone') }} <span style="font-size: 0.7rem">Ejem: (412)-891-5299</span>
          </label>
          <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Ej: (412)-891-5299" />
          <!-- pattern="^\(\d{3}\)-\d{3}-\d{4}$" -->
        </div>

        <div class="mt-4 md:col-span-2">
          <x-jet-label for="type" value="{{ __('auth.Type') }}" />
          <select name="type" id="type" class="block w-full border border-cdsolec-green-dark focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50 text-gray-800 rounded-md shadow">
            <option value="">Seleccione</option>
            @if ($types->isNotEmpty())
              @foreach($types as $type)
                <option value="{{ $type->rowid }}">{{ $type->label }}</option>
              @endforeach
            @endif
          </select>
        </div>

        <div class="mt-4">
          <x-jet-label for="password" value="{{ __('auth.Password') }}" />
          <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="********" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
          <x-jet-label for="password_confirmation" value="{{ __('auth.Confirm_Password') }}" />
          <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="********" required autocomplete="new-password" />
        </div>
      </div>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mt-4">
          <x-jet-label for="terms">
            <div class="flex items-center">
              <x-jet-checkbox name="terms" id="terms"/>

              <div class="ml-2">
                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                      'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                      'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                ]) !!}
              </div>
            </div>
          </x-jet-label>
        </div>
      @endif

      <x-jet-button class="w-full text-center mt-4">
        {{ __('auth.Register') }}
      </x-jet-button>
    </form>

    <hr class="my-4" />

    <div class="flex items-center justify-center mt-4">
      <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
        {{ __('auth.Already_registered') }}
      </a>
    </div>
  </x-jet-authentication-card>

  <script>
  (function() {
    'use strict';

    let phone = document.getElementById('phone');

    function formatTlf(e) {
      if((this.value.length < 15) && ((e.keyCode > 47 && e.keyCode < 58) || (e.keyCode > 95 && e.keyCode < 106))) {
        this.value = this.value.replace(/\(?(\d{3})\)?\-?(\d{3})\-?/, '($1)-$2-');
      } else {
        this.value = this.value.slice(0, -1);
      }
    }

    // phone.addEventListener('keyup', formatTlf);
  })();
  </script>
</x-guest-layout>
