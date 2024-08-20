<div class="inline-block">
  <button type="button" wire:click="confirmDeletion()" title="Eliminar" alt="Eliminar" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-red-600 hover:bg-red-500 tracking-wider rounded-md transition ml-2">
    <i class="fas fa-fw fa-sm fa-trash"></i>
  </button>

  <!-- Delete Confirmation Modal -->
  <x-jet-dialog-modal wire:model="open">
    <x-slot name="title">
      Confirmar Eliminación
    </x-slot>

    <x-slot name="content">
      ¿Estás seguro que deseas eliminar {{ $msg }}?
    </x-slot>

    <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('open')" wire:loading.attr="disabled">
        <i class="fas fa-fw fa-ban mr-2"></i> Cancelar
      </x-jet-secondary-button>

      <form method="post" action="{{ route($route, $model_id) }}" class="inline">
        {{ csrf_field() }}
        {{ method_field($method) }}
        <button type="submit" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-red-600 hover:bg-red-500 tracking-wider rounded-md transition ml-2">
          <i class="fas fa-fw fa-trash mr-2"></i> Eliminar
        </button>
      </form>
    </x-slot>
  </x-jet-dialog-modal>
</div>
