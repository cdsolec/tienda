<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-shopping-cart"></i> Compras
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span><a href="{{ route('orders.index') }}" class="text-cdsolec-green-dark">Compras</a></li>
				<li><span class="mx-2">/</span>Pagar</li>
			</ol>
		</nav>

		<div class="flex flex-wrap justify-center">
			<div class="w-full shadow rounded-md overflow-hidden bg-white px-4 py-3 sm:px-6">
				<h2 class="text-3xl leading-tight font-bold mt-4">Registrar Pago</h2>

				<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ (!session()->has('success')) ? 'hidden' : '' }}>
					{{ (session()->has('success')) ? session()->get('success') : '' }}
				</div>

        <div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 {{ ($errors->any()) ? 'block' : 'hidden' }}">
					<x-jet-validation-errors class="mb-4" />
				</div>

				<div class="my-2 p-3 rounded-lg border bg-gray-300">
					<div class="p-3 grid gap-3 grid-cols-1 md:grid-cols-3">
						<div>
							<p class="font-bold">Compra: {{ $commande->ref }}</p>
						</div>
						<div>
							<p class="font-bold">Fecha: {{ $commande->date_creation->format('d/m/Y') }}</p>
						</div>
						@php
							$total_bs = $commande->total_ht * $commande->multicurrency_tx;
							$iva_bs = $commande->total_tva * $commande->multicurrency_tx;
							$total_bs = $total_bs + $iva_bs;
						@endphp
						<div class="font-bold">
							Total: Bs {{ number_format($total_bs, 2, ',', '.') }} - $USD {{ number_format($commande->total_ttc, 2, ',', '.') }}
						</div>
					</div>
				</div>

				<div class="my-2 rounded-lg border bg-gray-300">
					<form action="{{ route('orders.payments.store', $commande) }}" method="POST">
						@csrf
            <div class="px-4 py-5 grid gap-3 grid-cols-1 md:grid-cols-2">
							<div class="relative w-full mb-3">
                <x-jet-label for="account" value="{{ __('* Cuenta Bancaria') }}" />
								<select name="account" id="account" class="block w-full border border-cdsolec-green-dark focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50 text-gray-800 rounded-md shadow" required>
									<option value="">Seleccione</option>
									@if ($accounts->isNotEmpty())
										@foreach ($accounts as $account)
											<option value="{{ $account->rowid }}">{{ $account->label }}</option>
										@endforeach
									@endif
								</select>
                <x-jet-input-error for="account" class="mt-2" />
              </div>

							<div class="relative w-full mb-3">
								<x-jet-label for="reference" value="{{ __('* Código de Referencia') }}" />
								<x-jet-input id="reference" type="number" name="reference" required />
								<x-jet-input-error for="reference" class="mt-2" />
							</div>

							<div class="relative w-full mb-3">
								<x-jet-label for="name" value="{{ __('* Fecha') }}" />
								<div class="relative flatpickrFrom">
									<input type="text" id="date" name="date" value="{{ request('date') }}" class="w-full border border-cdsolec-green-dark focus:border-cdsolec-green-dark focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow" readonly data-input />
									<a class="input-button cursor-pointer" title="toggle" data-toggle>
										<i class="fas fa-calendar p-3 text-cdsolec-green-dark absolute right-0"></i>
									</a>
								</div>
              </div>

							<div class="relative w-full mb-3">
                <x-jet-label for="type" value="{{ __('* Tipo') }}" />
								<select name="type" id="type" class="block w-full border border-cdsolec-green-dark focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50 text-gray-800 rounded-md shadow" required>
									<option value="">Seleccione</option>
									@if ($types->isNotEmpty())
										@foreach ($types as $type)
											<option value="{{ $type->id }}">{{ $type->libelle }}</option>
										@endforeach
									@endif
								</select>
								<x-jet-input-error for="type" class="mt-2" />
							</div>

							<div class="relative w-full mb-3">
									<x-jet-label for="amount" value="{{ __('* Monto $USD') }}" />
									<x-jet-input id="amount" type="number" name="amount" min="0" step="0.01" required />
									<x-jet-input-error for="amount" class="mt-2" />
							</div>
						</div>

						<div class="flex items-center justify-end px-4 py-3 bg-gray-100 text-right sm:px-6">
								<x-jet-button type="submit">Guardar</x-jet-button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script>
			(function() {
				'use strict';

				let fromPicker = flatpickr(".flatpickrFrom", {
					dateFormat: "d/m/Y",
					wrap: true,
					disableMobile: true
				});
			})();
		</script>
	@endpush
</x-dashboard-layout>
