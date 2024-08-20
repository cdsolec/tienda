<div class="inline-block">
  <x-jet-dialog-modal wire:model="showingModal">
      <x-slot name="title">
      </x-slot>

      <x-slot name="content">
        <img src="img/FINANO2023-2.jpeg" alt="AÑO NUEVO 2024" title="AÑO NUEVO 2024" />
      </x-slot>

      <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
          Cerrar
        </x-jet-secondary-button>
      </x-slot>
  </x-jet-dialog-modal>
</div>
