<x-guest-layout>
  <x-jet-authentication-card width="small">
    <x-slot name="logo">
      <x-jet-authentication-card-logo />
    </x-slot>

    <div class="mb-4 text-sm text-gray-600">
      {{ __('auth.forgot_msg') }}
    </div>

    @if (session('status'))
      <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
      </div>
    @endif

    <x-jet-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="block">
        <x-jet-label for="email" value="{{ __('auth.Email') }}" />
        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
      </div>

      <div class="flex items-center justify-end mt-4">
        <x-jet-button>
          {{ __('auth.reset_link') }}
        </x-jet-button>
      </div>
    </form>

    <hr class="my-4" />

    <div class="flex items-center justify-between mt-4">
      @if (Route::has('login'))
        <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
          {{ __('auth.Login') }}
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
