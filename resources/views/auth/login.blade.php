<x-guest-layout>
  <x-jet-authentication-card width="small">
    <x-slot name="logo">
      <x-jet-authentication-card-logo />
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    @if (session('status'))
      <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div>
        <x-jet-label for="email" value="{{ __('auth.Email') }}" />
        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
      </div>

      <div class="mt-4">
        <x-jet-label for="password" value="{{ __('auth.Password') }}" />
        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
      </div>

      <x-jet-button class="w-full text-center mt-4">
        {{ __('auth.Login') }}
      </x-jet-button>
    </form>

    <hr class="my-4" />

    <div class="flex items-center justify-between mt-4">
      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
          {{ __('auth.Forgot_password') }}
        </a>
      @endif

      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
          {{ __('auth.Register') }}
        </a>
      @endif
    </div>
  </x-jet-authentication-card>
</x-guest-layout>
