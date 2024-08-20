<x-jet-form-section submit="updatePassword">
  <x-slot name="title">
    {{ __('session.Update_Password') }}
  </x-slot>

  <x-slot name="description">
    {{ __('session.Update_Password_msg') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="current_password" value="{{ __('session.Current_Password') }}" />
      <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
      <x-jet-input-error for="current_password" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="password" value="{{ __('session.New_Password') }}" />
      <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
      <x-jet-input-error for="password" class="mt-2" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="password_confirmation" value="{{ __('session.Confirm_Password') }}" />
      <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
      <x-jet-input-error for="password_confirmation" class="mt-2" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-jet-action-message class="mr-3" on="saved">
      {{ __('session.Password_Saved') }}
    </x-jet-action-message>

    <x-jet-button>
      <i class="fas fa-fw fa-lock"></i> {{ __('session.Update_Password') }}
    </x-jet-button>
  </x-slot>
</x-jet-form-section>
