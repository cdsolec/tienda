<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-cogs"></i> Direcciones
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span>Direcciones</li>
			</ol>
		</nav>

		<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ (!session()->has('message')) ? 'hidden' : '' }}>
			{{ session()->has('message') ? session()->get('message') : '' }}
		</div>

		<div class="my-3 p-3 bg-white overflow-hidden border border-gray-200 shadow-lg sm:rounded-lg">
			<form method="get" action="{{ route('address.index') }}">
				@csrf
				<div class="grid grid-cols-1 md:grid-cols-12 gap-3">
					<div class="col-span-12 md:col-span-5">
						<x-jet-label for="search" value="Buscar" class="hidden" />
						<x-jet-input type="text" id="search" name="search" placeholder="Buscar..." value="{{ request('search') }}" />
					</div>
					<div class="col-span-12 md:col-span-3">
						<x-jet-label for="from" value="Desde" class="hidden" />
						<div class="relative flatpickrFrom">
							<input type="text" id="from" name="from" placeholder="Desde" value="{{ request('from') }}" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow" readonly data-input />
							<a class="input-button cursor-pointer" title="toggle" data-toggle>
								<i class="fas fa-calendar p-3 text-cdsolec-green-dark absolute right-0"></i>
							</a>
						</div>
					</div>
					<div class="col-span-12 md:col-span-3">
						<x-jet-label for="to" value="Hasta" class="hidden" />
						<div class="relative flatpickrTo">
							<input type="text" id="to" name="to" placeholder="Hasta" value="{{ request('to') }}" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow" readonly data-input />
							<a class="input-button cursor-pointer" title="toggle" data-toggle>
								<i class="fas fa-calendar p-3 text-cdsolec-green-dark absolute right-0"></i>
							</a>
						</div>
					</div>
					<div class="col-span-12 md:col-span-1">
						<x-jet-button class="border-none bg-blue-600">
							<i class="fas fa-search text-white"></i>
						</x-jet-button>
					</div>
				</div>
			</form>
		</div>

		<div class="my-3 flex justify-end">
			<a href="{{ route('address.create') }}" title="Agregar" alt="Agregar" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-green-600 hover:bg-green-500 tracking-wider rounded-md transition">
				<i class="fas fa-fw fa-plus-square"></i> Agregar Nuevo
			</a>
			<a href="{{ route('address.trash') }}" title="Papelera" alt="Papelera" class="ml-2 px-3 py-2 font-semibold uppercase text-sm text-white bg-red-600 hover:bg-red-500 tracking-wider rounded-md transition">
				<i class="fas fa-fw fa-trash-restore"></i> Ver Papelera
			</a>
		</div>

    <table class="my-3 w-full rounded-lg overflow-hidden shadow-md">
      <thead>
        <tr class="hidden lg:table-row bg-cdsolec-green-dark text-white text-sm leading-4 uppercase tracking-wider">
          <th class="px-3 py-3 font-medium text-left">
            Direccion
          </th>
          <th class="px-2 py-3 font-medium text-left">
            Titulo
          </th>
          <th style="width: 110px" class="px-2 py-3 font-medium text-center">
            Fecha
          </th>
          <th style="width: 120px" class="px-3 py-3 font-medium text-center">
            Opciones
          </th>
        </tr>
      </thead>
      @if ($address->isNotEmpty())
        <tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
          @foreach($address as $dir)
            <tr class="flex flex-col lg:table-row even:bg-gray-200">
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Direccion
                </div>
                <div class="p-2 flex items-center">
                  <div>
                    <div class="text-sm leading-5 font-semibold">
                      {{ $dir->address }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Titulo
                </div>
                <div class="p-2">
                  {{ $dir->lastname }}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Fecha
                </div>
                <div class="p-2 text-center">
                  {{ date('d/m/Y', strtotime($dir->datec))}}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Opciones
                </div>
                <div class="p-2 text-center">
                  <a href="{{ route('address.edit', $dir) }}" title="Editar" alt="Editar" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-blue-600 hover:bg-blue-500 tracking-wider rounded-md transition">
                    <i class="fas fa-sm fa-edit"></i>
                  </a>
                  @livewire('delete-modal', [
                    'msg' => 'la Direccion',
                    'model_id' => $dir,
                    'route' => 'address.destroy',
                    'method' => 'delete'
                  ])
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      @endif
    </table>

		{{ $address->links() }}
	</div>

  @push('scripts')
    <script>
      (function () {
        'use strict';

        let fromPicker = flatpickr(".flatpickrFrom", {
          dateFormat: "d/m/Y",
          wrap: true,
          disableMobile: true,
          onChange: function(selectedDates, dateStr, instance) {
            toPicker.set('minDate', selectedDates[0]);
          }
        });

        let toPicker = flatpickr(".flatpickrTo", {
          dateFormat: "d/m/Y",
          wrap: true,
          disableMobile: true,
          onChange: function(selectedDates, dateStr, instance) {
            fromPicker.set('maxDate', selectedDates[0]);
          }
        });
      })();
    </script>
  @endpush
</x-dashboard-layout>
