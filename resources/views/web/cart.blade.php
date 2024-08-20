<x-web-layout title="Compra">
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
			<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
				Detalle de su compra
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">Orden de Compra</h2>

			<div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 {{ ($errors->any()) ? 'block' : 'hidden' }}">
				<x-jet-validation-errors class="mb-4" />
			</div>

			@if (session()->has('cart') && (count($cart) > 0))
				@php
					$total = ['bs' => 0, 'usd' => 0];
					$iva = ['bs' => 0, 'usd' => 0];
				@endphp

				<input type="hidden" name="tasa_usd" id="tasa_usd" value="{{ $tasa_usd }}" />
				<div class="w-full py-3 mb-3" id="table">
					<table class="my-2 w-full rounded-lg overflow-hidden bg-white border-collapse border border-green-800">
						<thead class="border bg-gray-300">
							<tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
								<th class="px-3 py-4 border-2 text-left">Producto</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 100px">Cantidad</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 200px">Precio</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 220px">Sub-Total</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 40px">&nbsp;</th>
							</tr>
						</thead>
						<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
							@foreach($cart as $item)
								@php
									$subtotal['bs'] = $item['price'] * $tasa_usd * $item['quantity'];
									$subtotal['usd'] = $item['price'] * $item['quantity'];
									$total['bs'] += $subtotal['bs'];
									$total['usd'] += $subtotal['usd'];
								@endphp
								<tr class="flex flex-col lg:table-row even:bg-gray-300">
									<td class="flex flex-row lg:table-cell border-2">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Producto
										</div>                         
										<div class="px-3 py-2 lg:py-4 flex items-center">
											<div class="flex-shrink-0 h-10 w-10 mr-4">
												<img class="h-10 w-10 rounded-full" src="{{ asset($item['image']) }}" alt="{{ $item['label'] }}" title="{{ $item['label'] }}" />
											</div>
											<div class="leading-5 font-bold">
												<p class="text-sm text-cdsolec-blue-light">{{ $item['label'] }}</p>
												<p>Ref: {{ $item['ref'] }}</p>
											</div>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Cantidad
										</div>                    
										<div class="px-3 py-2 lg:py-4 text-right">             
											<div class="w-full flex pb-2">
												<button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
												<input type="number" name="quantity" id="quantity{{ $item['id'] }}" min="0" max="{{ $item['stock'] }}" step="1" data-stock="{{ $item['stock'] }}" data-product="{{ $item['id'] }}" data-price="{{ $item['price'] }}" value="{{ $item['quantity'] }}" class="w-16 text-right px-3" onchange="validateRange(this)" />
												<button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
											</div>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Precio
										</div>
										<div class="px-3 py-2 lg:py-4 lg:text-right">
											<p>Bs {{ number_format($item['price'] * $tasa_usd, 2, ',', '.') }}</p>
											<p class="font-bold">$USD {{ number_format($item['price'], 2, ',', '.') }}</p>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Sub-Total
										</div>
										<div class="px-3 py-2 lg:py-4 lg:text-right">
											<p>
												Bs 
												<span id="subtotal_bs_{{ $item['id'] }}">
													{{ number_format($subtotal['bs'], 2, ',', '.') }}
												</span>
											</p>
											<p class="font-bold">
												$USD 
												<span id="subtotal_usd_{{ $item['id'] }}">
													{{ number_format($subtotal['usd'], 2, ',', '.') }}
												</span>
											</p>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center lg:text-center text-sm leading-5 font-medium">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Opciones
										</div>
										<div class="px-3 py-2 lg:py-4">
											<form id="form-delete" name="form-delete" method="POST" action="{{ route('cart.destroy', $item['id']) }}">
												@csrf
												@method('DELETE')
												<button type="submit" class="bg-red-500 text-white rounded-md p-2 hover:bg-red-300">
													<i class="fas fa-times"></i>
												</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										SubTotal
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										SubTotal
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										SubTotal
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="subtotal_bs">
												{{ number_format($total['bs'], 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="subtotal_usd">
												{{ number_format($total['usd'], 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">&nbsp;</td>
							</tr>
							@php
								$iva['bs'] = ($total['bs'] * $percent_iva) / 100;
								$iva['usd'] = ($total['usd'] * $percent_iva) / 100;
							@endphp
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										IVA
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										IVA
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										IVA
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="iva_bs">
												{{ number_format($iva['bs'], 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="iva_usd">
												{{ number_format($iva['usd'], 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">&nbsp;</td>
							</tr>
							@php
								$total['bs'] = $total['bs'] + $iva['bs'];
								$total['usd'] = $total['usd'] + $iva['usd'];
							@endphp
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										Total
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										Total
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										Total
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="total_bs">
												{{ number_format($total['bs'], 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="total_usd">
												{{ number_format($total['usd'], 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="flex justify-between">
					<div>
						<a href="{{ route('products') }}" class="bg-cdsolec-green-light text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-dark">
							<i class="fas fa-chevron-circle-left"></i> Agregar Productos
						</a>
					</div>
					<div>
						<a href="{{ route('cart.clear') }}" class="bg-red-500 text-white rounded-lg px-3 py-2 mx-3">
							<i class="fas fa-times text-white"></i> Cancelar Pedido
						</a>
					</div>
					<div class="text-right">
						<form id="form-cart" name="form-cart" method="POST" action="{{ route('cart.checkout') }}">
							@csrf
							<button type="submit" class="bg-cdsolec-green-dark text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-light">
								Comprar <i class="fas fa-chevron-circle-right"></i>
							</button>
						</form>
						<form id="form-cart2" name="form-cart2" method="POST" action="{{ route('basket.checkout') }}" class="mt-4">
							@csrf
							<input type="hidden" name="checkout_basket" id="checkout_basket" value="1" />
							<button type="submit" class="bg-cdsolec-green-dark text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-light">
								Presupuesto <i class="fas fa-chevron-circle-right"></i>
							</button>
						</form>
					</div>
				</div>
			@else
				<div class="mx-4 mt-5 text-sm text-blue-800 p-2 rounded bg-blue-light border border-blue-800">
					<h5>¡No ha agregado ningún producto!</h5>
					<p>Haga clic <a href="{{ route('products') }}" class="font-semibold">aqui</a> para ver el catálogo de los Productos.</p>
				</div>
			@endif
		</div>
	@endsection

	@push('scripts')
		<script>
			function decrement(e) {
				const btn = e.target.parentNode.parentElement.querySelector(
					'button[data-action="decrement"]'
				);
				const target = btn.nextElementSibling;
				let value = Number(target.value);
				value--;
				if (value < 0) value = 0;
				target.value = value;

				const tasa_usd = Number(document.getElementById('tasa_usd').value);
				let product = Number(target.dataset.product);
				let price = Number(target.dataset.price);

				let subtotal_bs = new Intl.NumberFormat("es-ES").format(price * tasa_usd * value);
				let subtotal_usd = new Intl.NumberFormat("es-ES").format(price * value);

				const data = {};
				data._method = 'PUT';
				data.quantity = value;
				const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

				fetch('/cart/' + product, {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-CSRF-Token": csrfToken
					},
					body: JSON.stringify(data),
				})
				.then((response) => response.json())
				.then((data) => {
					console.log("Success:", data);
					document.getElementById('subtotal_bs_' + product).innerHTML = subtotal_bs;
					document.getElementById('subtotal_usd_' + product).innerHTML = subtotal_usd;
					document.getElementById('subtotal_bs').innerHTML = data.subtotal_bs;
					document.getElementById('subtotal_usd').innerHTML = data.subtotal_usd;
					document.getElementById('iva_bs').innerHTML = data.iva_bs;
					document.getElementById('iva_usd').innerHTML = data.iva_usd;
					document.getElementById('total_bs').innerHTML = data.total_bs;
					document.getElementById('total_usd').innerHTML = data.total_usd;
				})
				.catch((error) => {
					console.error("Error:", error);
				});
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

				const tasa = Number(document.getElementById('tasa_usd').value);
				let product = Number(target.dataset.product);
				let price = Number(target.dataset.price);

				let subtotal_bs = new Intl.NumberFormat("es-ES").format(price * tasa * value);
				let subtotal_usd = new Intl.NumberFormat("es-ES").format(price * value);

				const data = {};
				data._method = 'PUT';
				data.quantity = value;
				const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

				fetch('/cart/' + product, {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-CSRF-Token": csrfToken
					},
					body: JSON.stringify(data),
				})
				.then((response) => response.json())
				.then((data) => {
					console.log("Success:", data);
					document.getElementById('subtotal_bs_' + product).innerHTML = subtotal_bs;
					document.getElementById('subtotal_usd_' + product).innerHTML = subtotal_usd;
					document.getElementById('subtotal_bs').innerHTML = data.subtotal_bs;
					document.getElementById('subtotal_usd').innerHTML = data.subtotal_usd;
					document.getElementById('iva_bs').innerHTML = data.iva_bs;
					document.getElementById('iva_usd').innerHTML = data.iva_usd;
					document.getElementById('total_bs').innerHTML = data.total_bs;
					document.getElementById('total_usd').innerHTML = data.total_usd;
				})
				.catch((error) => {
					console.error("Error:", error);
				});
			}

			function validateRange(element) {
				if (element.value < element.min) element.value = element.min;
				if (element.value > element.max) element.value = element.max;
			}

			const decrementButtons = document.querySelectorAll('button[data-action="decrement"]');
			const incrementButtons = document.querySelectorAll('button[data-action="increment"]');

			decrementButtons.forEach(btn => {
				btn.addEventListener("click", decrement);
			});

			incrementButtons.forEach(btn => {
				btn.addEventListener("click", increment);
			});
		</script>
	@endpush
</x-web-layout>