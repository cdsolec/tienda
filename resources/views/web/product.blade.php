<x-web-layout title="Producto">
	@push('styles')
		<style>
			/* Chrome, Safari, Edge, Opera */
			input::-webkit-outer-spin-button,
			input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}

			/* Firefox */
			input[type=number] {
				-moz-appearance: textfield;
			}
		</style>
	@endpush

	@section('background', asset('img/slide1.jpg'))

	@section('content')
    <div class="container mx-auto px-6">
			<nav class="mb-4">
				<ol class="flex flex-wrap text-cdsolec-blue-light font-semibold text-xl">
					<li>
						<a href="{{ route('welcome') }}">Inicio</a><span class="mx-2">/</span>
					</li>
					<li>
						<a href="{{ route('products') }}">Productos</a><span class="mx-2">/</span>
					</li>
					<li class="uppercase font-semibold tracking-widest">
						Detalle del Producto
					</li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
				<div>
					<div class="mb-3 border border-cdsolec-green-dark overflow-hidden rounded-lg flex justify-center content-center">
						<img src="{{ asset($image) }}" alt="{{ $product->label }}" title="{{ $product->label }}" class="h-60 w-60 rounded-lg" />
					</div>
					@if ($product->documents->isNotEmpty())
						@php $documents = $product->documents->sortBy('position'); @endphp
						<div class="grid grid-cols-1 lg:grid-cols-4 gap-2">
							@foreach ($documents as $document)
								@php
									if (app()->environment('production')) {
										$image = '/storage/produit/'.$product->ref.'/'.$document->filename;
									} else {
										$image = '/img/favicon/apple-icon.png';
									}
								@endphp
								@if (pathinfo($document->filename, PATHINFO_EXTENSION) == 'jpg')
									<div class="rounded-lg border border-cdsolec-green-dark">
										<img src="{{ asset($image) }}" alt="{{ $product->label }}" title="{{ $product->label }}" class="rounded-lg" />
									</div>
								@endif
							@endforeach
						</div>
					@endif
				</div>
				<div>
					<h2 class="text-cdsolec-green-dark font-semibold text-lg py-1">{{ $product->label }}</h2>
					@if ($extrafields->isNotEmpty())
						@php
							$product_fields = $product->extrafields->toArray();
						@endphp
						<h3 class="font-semibold">{{ $product_fields['at1'] }}</h3>
					@endif
					<h3 class="uppercase font-semibold tracking-widest">Ref: {{ $product->ref }}</h3>
					<h4 class="font-bold">Descripción</h4>
					{!! $product->description !!}
					<!-- @if ($datasheet)
						<p>
							<a href="{{ $datasheet }}" target="_blank">
								<img class="h-5 w-5 inline" src="{{ asset('img/pdf.png') }}" alt="Datasheet" title="Datasheet" /> Descargar Datasheet
							</a>
						</p>
					@endif -->
					@if ($product->url)
						<p>
							<a href="{{ $product->url }}" target="_blank" class="text-blue-600">Ver Video</a>
						</p>
					@endif
					@if ($product->documents->isNotEmpty())
						@foreach ($product->documents as $document)
							@if (pathinfo($document->filename, PATHINFO_EXTENSION) == 'pdf')
								<p>
									<a href="{{ '/storage/produit/'.$product->ref.'/'.$document->filename }}" target="_blank">
										<img class="h-5 w-5 inline" src="{{ asset('img/pdf.png') }}" alt="Datasheet" title="Datasheet" /> {{ $document->filename }}
									</a>
								</p>
							@endif
						@endforeach
					@endif
				</div>
				<div>
					@php
						$stock = $product->stock - $product->seuil_stock_alerte;

						$price_original = $product->prices->where('price_level', 1)->first();
						$price_client = $product->prices->where('price_level', $price_level)->first();
						if ($price_client == null) {
							$price_client = $price_original;
						}

						$cart = session()->get('cart', []);
					@endphp
					@if ($stock > 0)
						@if ((count($cart) > 0) && isset($cart[$product->rowid]))
							<form id="form-delete" name="form-delete" method="POST" action="{{ route('cart.destroy', $product->rowid) }}">
								@csrf
								@method('DELETE')
								<button type="submit" class="px-4 py-1 font-semibold bg-red-600 text-white uppercase text-xs">
									Eliminar <i class="fas fa-cart-arrow-down"></i>
								</button>
							</form>
						@else
							<form action="{{ route('cart.store') }}" method="POST" class="flex flex-col lg:flex-row justify-between">
								@csrf
								<input type="hidden" name="product" value="{{ $product->rowid }}" />
								<div class="flex p-1">
									<button type="button" class="px-3 py-2 my-1 border border-gray-500 font-semibold" data-action="decrement">-</button>
									<input type="number" name="quantity" id="quantity" min="0" max="{{ $stock }}" step="1" data-stock="{{ $stock }}" data-price="{{ $price_client->price_discount }}" data-tasa="{{ $tasa_usd }}" value="0" class="w-20 my-1 text-right" onchange="validateRange(this)" />
									<button type="button" class="px-3 py-2 my-1 border border-gray-500 font-semibold" data-action="increment">+</button>
								</div>
								<div class="m-2">
									<button type="submit" class="p-3 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
										Agregar al Carrito <i class="fas fa-shopping-cart"></i>
									</button>
								</div>
							</form>
						@endif
					@else
						<a href="{{ route('stock', $product->ref) }}" class="inline-block my-1 px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs text-center">
							Consultar Disponibilidad
						</a>
					@endif
					<p><strong>Precio</strong></p>
					<table class="w-full pb-3 border-collapse border border-gray-300 text-sm">
						<thead>
							<tr>
								<th class="p-2 text-left">Moneda</th>
								<th class="p-2 text-right">Cant.</th>
								<th class="p-2 text-right">Precio</th>
								<th class="p-2 text-right">Subtotal</th>
							</tr>
						</thead>
						<tbody>
							<tr class="bg-gray-300 border border-gray-300">
								<td class="line-through text-red-600 p-2 text-left">$USD</td>
								<td class="line-through text-red-600 p-2 text-right">{{ $quantity = 1 }}</td>
								<td class="line-through text-red-600 p-2 text-right">
									{{ number_format($price_original->price_discount, 2, ',', '.') }}
								</td>
								<td class="line-through text-red-600 p-2 text-right font-semibold">
									{{ number_format(($price_original->price_discount * $quantity), 2, ',', '.') }}
								</td>
							</tr>
							<tr class="border border-gray-300">
								<td class="p-2 text-left">$USD</td>
								<td id="quantity_usd" class="p-2 text-right">{{ $quantity = 1 }}</td>
								<td class="p-2 text-right">
									{{ number_format($price_client->price_discount, 2, ',', '.') }}
								</td>
								<td id="subtotal_usd" class="p-2 text-right text-cdsolec-green-dark font-semibold">
									{{ number_format(($price_client->price_discount * $quantity), 2, ',', '.') }}
								</td>
							</tr>
							<tr class="bg-gray-300 border border-gray-300">
								<td class="p-2 text-left">Bs</td>
								<td id="quantity_bs" class="p-2 text-right">{{ $quantity = 1 }}</td>
								<td class="p-2 text-right">
									{{ number_format(($price_client->price_discount * $tasa_usd), 2, ',', '.') }}
								</td>
								<td id="subtotal_bs" class="p-2 text-right text-cdsolec-green-dark font-semibold">
									{{ number_format(($price_client->price_discount * $tasa_usd * $quantity), 2, ',', '.') }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="lg:col-span-2">
					<p><strong>Especificaciones del Producto:</strong></p>
					<form method="GET" action="{{ route('products') }}" >
						@csrf
						<table class="w-full pb-3 border-collapse border border-gray-300 text-sm">
							<thead>
								<tr class="bg-gray-300">
									<th class="p-2 text-left">Atributo</th>
									<th class="p-2 text-left">Valor</th>
									<th class="p-2 text-center" style="width: 60px">Buscar</th>
								</tr>
							</thead>
							@if ($extrafields->isNotEmpty())
								@php
									$product_fields = $product->extrafields->toArray();
								@endphp
								<tbody>
									@foreach ($extrafields as $extrafield)
										@if (isset($product_fields[$extrafield->name]) && ($product_fields[$extrafield->name] != null) && ($product_fields[$extrafield->name] != 'N/A'))
											<tr class="even:bg-gray-300">
												<td class="p-2 text-left">
													{{ (isset($attributes[$extrafield->name])) ? $attributes[$extrafield->name] : $extrafield->name }}
												</td>
												<td class="p-2 text-left">{{ $product_fields[$extrafield->name] }}</td>
												<td class="p-2 text-center">
													<label for="field_{{ $extrafield->name }}" class="flex justify-center items-center">
														<input type="checkbox" data-filter="{{ $extrafield->name }}" name="{{ $extrafield->name }}[]" id="{{ $extrafield->name }}_{{ $loop->iteration }}" class="checkfilter border border-cdsolec-green-dark rounded text-cdsolec-green-dark shadow-sm focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50" value="{{ $product_fields[$extrafield->name] }}" />
													</label>
												</td>
											</tr>
										@endif
									@endforeach
									<tr>
										<td colspan="3" class="p-2 text-center">
											<x-jet-button type="submit">
												Buscar <i class="fas fa-search"></i>
											</x-jet-button>
										</td>
									</tr>
								</tbody>
							@endif
						</table>
					</form>
				</div>
			</div>
		</div>
	@endsection

	@push('scripts')
		<script>
			function handleCheck() {
				let myCheckFilters = document.querySelectorAll(".checkfilter:checked");
				let querystring = '?';
				let dataArray = [];

				myCheckFilters.forEach(item => {
					querystring = querystring + '&' + encodeURIComponent(item.dataset.filter) + '[]=' + encodeURIComponent(item.value);
				});

				let url = '/products' + querystring;

				location.href = url;
			}

			function decrement(e) {
				const btn = e.target.parentNode.parentElement.querySelector(
					'button[data-action="decrement"]'
				);
				const target = btn.nextElementSibling;
				let value = Number(target.value);
				value--;
				if (value < 0) value = 0;
				target.value = value;

				let price = Number(target.dataset.price);
				let tasa = Number(target.dataset.tasa);

				let subtotal_bs = new Intl.NumberFormat("es-ES").format(price * tasa * value);
				let subtotal_usd = new Intl.NumberFormat("es-ES").format(price * value);

				document.getElementById('quantity_bs').innerHTML = value;
				document.getElementById('quantity_usd').innerHTML = value;
				document.getElementById('subtotal_bs').innerHTML = subtotal_bs;
				document.getElementById('subtotal_usd').innerHTML = subtotal_usd;
			}

			function increment(e) {
				const btn = e.target.parentNode.parentElement.querySelector(
					'button[data-action="decrement"]'
				);
				const target = btn.nextElementSibling;
				let value = Number(target.value);
				value++;
				if (value > target.max) value = Number(target.max);
				target.value = value;

				let price = Number(target.dataset.price);
				let tasa = Number(target.dataset.tasa);

				let subtotal_bs = new Intl.NumberFormat("es-ES").format(price * tasa * value);
				let subtotal_usd = new Intl.NumberFormat("es-ES").format(price * value);

				document.getElementById('quantity_bs').innerHTML = value;
				document.getElementById('quantity_usd').innerHTML = value;
				document.getElementById('subtotal_bs').innerHTML = subtotal_bs;
				document.getElementById('subtotal_usd').innerHTML = subtotal_usd;
			}

			function validateRange(element) {
				if (element.value < element.min) element.value = element.min;
				if (element.value > element.max) element.value = element.max;
			}

			const decrementButton = document.querySelector('button[data-action="decrement"]');
			const incrementButton = document.querySelector('button[data-action="increment"]');

			decrementButton.addEventListener("click", decrement);
			incrementButton.addEventListener("click", increment);
		</script>
	@endpush
</x-web-layout>