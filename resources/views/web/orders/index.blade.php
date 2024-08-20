<x-dashboard-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
      <i class="fas fa-shopping-cart"></i> Pedidos
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
    <nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span>Pedidos</li>
			</ol>
		</nav>

		<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ (!session()->has('message')) ? 'hidden' : '' }}>
			{{ session()->has('message') ? session()->get('message') : '' }}
		</div>

		<div class="my-3 p-3 bg-white overflow-hidden border border-gray-200 shadow-lg sm:rounded-lg">
			<form method="get" action="{{ route('orders.index') }}">
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

    <table class="my-3 w-full rounded-lg overflow-hidden shadow-md">
			<thead>
				<tr class="hidden lg:table-row bg-cdsolec-green-dark text-white text-sm leading-4 uppercase tracking-wider">
					<th style="width: 120px" class="px-3 py-3 font-medium text-center">
						REF
					</th>
					<th class="px-3 py-3 font-medium text-left">
						Nombre del Proyecto
					</th>
					<th style="width: 200px" class="px-3 py-3 font-medium text-right">
						Total
					</th>
					<th style="width: 200px" class="px-3 py-3 font-medium text-center">
						Estatus
					</th>
					<th style="width: 120px" class="px-3 py-3 font-medium text-center">
						Fecha
					</th>
					<th style="width: 200px" class="px-3 py-3 font-medium text-center">
						Opciones
					</th>
				</tr>
			</thead>
			@if ($orders->isNotEmpty())
        <tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
          @foreach($orders as $order)
            @php
							$total_bs = $order->total_ht * $order->multicurrency_tx;
              $iva_bs = $order->total_tva * $order->multicurrency_tx;
              $total_bs = $total_bs + $iva_bs;
						@endphp
            <tr class="flex flex-col lg:table-row even:bg-gray-200">
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  REF
                </div>
                <div class="p-2 text-center text-sm font-bold">
                  {{ $order->ref }}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Nombre
                </div>
                <div class="p-2">
                  {{ $order->ref_client }}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Total
                </div>
                <div class="p-2 lg:text-right font-bold">
                  <p>Bs {{ number_format($total_bs, 2, ',', '.') }}</p>
                  <p>$USD {{ number_format($order->total_ttc, 2, ',', '.') }}</p>
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Estatus
                </div>
                <div class="p-2 text-center">
                  {{ $order->status }}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Fecha
                </div>
                <div class="p-2 text-center">
                  {{ $order->date_creation->format('d/m/Y') }}
                </div>
              </td>
              <td class="flex flex-row lg:table-cell">
                <div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
                  Opciones
                </div>
                <div class="p-2 text-center">
                  <a href="{{ route('cart.reload', ['type' => 'order', 'id' => $order->rowid]) }}" title="Recargar Pedido" alt="Recargar Pedido" class="mr-1 p-2 inline-block rounded-md font-semibold uppercase text-xl text-yellow-600 bg-gray-300 hover:bg-gray-400 tracking-wider transition">
                    <i class="fas fa-sm fa-fw fa-shopping-cart"></i>
                  </a>
                  <a href="{{ route('orders.pdf', $order) }}" target="_blank" title="Imprimir PDF" alt="Imprimir PDF" class="mr-1 p-2 inline-block rounded-md font-semibold uppercase text-xl text-red-600 bg-gray-300 hover:bg-gray-400 tracking-wider transition">
                    <i class="far fa-sm fa-fw fa-file-pdf"></i>
                  </a>
                  <a href="{{ route('orders.payments.create', $order) }}" title="Pagos" alt="Pagos" class="mr-1 p-2 inline-block rounded-md font-semibold uppercase text-xl text-green-700 bg-gray-300 hover:bg-gray-400 tracking-wider transition">
                    <i class="fas fa-sm fa-fw fa-dollar-sign"></i>
                  </a>
                  <a href="{{ route('orders.show', $order) }}" title="Detalles" alt="Detalles" class="p-2 inline-block rounded-md font-semibold uppercase text-xl text-blue-600 bg-gray-300 hover:bg-gray-400 tracking-wider transition">
                    <i class="fas fa-sm fa-fw fa-file"></i>
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      @endif
		</table>

		{{ $orders->links() }}
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
