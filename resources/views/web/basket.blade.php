<x-web-layout title="Presupuesto">
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
				Detalle de su Presupuesto
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">Presupuesto</h2>

			<div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 {{ ($errors->any()) ? 'block' : 'hidden' }}">
				<x-jet-validation-errors class="mb-4" />
			</div>

			@if (session()->has('basket') && (count($basket) > 0))
				<div class="w-full py-3 mb-3" id="table">
					<table class="my-2 w-full rounded-lg overflow-hidden bg-white border-collapse border border-green-800">
						<thead class="border bg-gray-300">
							<tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
								<th class="px-3 py-4 border-2 text-left">Producto</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 100px">Cantidad</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 40px">&nbsp;</th>
							</tr>
						</thead>
						<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
							@foreach($basket as $item)
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
												<input type="number" name="quantity" id="quantity{{ $item['id'] }}" data-product="{{ $item['id'] }}" min="0" step="1" value="{{ $item['quantity'] }}" class="w-16 text-right px-3" />
												<button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
											</div>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center lg:text-center text-sm leading-5 font-medium">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Opciones
										</div>
										<div class="px-3 py-2 lg:py-4">
											<form id="form-delete" name="form-delete" method="POST" action="{{ route('basket.destroy', $item['id']) }}">
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
						</tbody>
					</table>
				</div>
				
				<div class="flex justify-between">
					<a href="{{ route('products') }}" class="bg-cdsolec-green-light text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-dark">
						<i class="fas fa-chevron-circle-left"></i> Agregar Productos
					</a>
					<a href="{{ route('basket.clear') }}" class="bg-red-500 text-white rounded-lg px-3 py-2 mx-3">
						<i class="fas fa-times text-white"></i> Cancelar Presupuesto
					</a>
					<form id="form-basket" name="form-basket" method="POST" action="{{ route('basket.checkout') }}">
						@csrf
						<button type="submit" class="bg-cdsolec-green-dark text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-light">
							Enviar <i class="fas fa-chevron-circle-right"></i>
						</button>
					</form>
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

				let product = Number(target.dataset.product);

				const data = {};
				data._method = 'PUT';
				data.quantity = value;
				const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

				fetch('/basket/' + product, {
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
				target.value = value;

				let product = Number(target.dataset.product);

				const data = {};
				data._method = 'PUT';
				data.quantity = value;
				const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

				fetch('/basket/' + product, {
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
				})
				.catch((error) => {
					console.error("Error:", error);
				});
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