<x-web-layout title="Productos">
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
		<nav class="mb-2">
			<ol class="flex flex-wrap text-cdsolec-blue-light font-semibold text-xl">
				<li>
					<a href="{{ route('welcome') }}">Inicio</a><span class="mx-2">/</span>
				</li>
				<li>
					<a href="{{ route('products') }}">Productos</a><span class="mx-2">/</span>
				</li>
			</ol>
		</nav>

		<nav class="my-2">
			<ol class="flex flex-wrap text-cdsolec-green-dark font-semibold text-xl">
				@if ($category->parent)
					<li>
						<a href="{{ route('products') }}?category={{ $category->parent->rowid }}">{{ $category->parent->label }}</a><span class="mx-2">/</span>
					</li>
				@endif
				<li>
					<a href="{{ route('products') }}?category={{ $category->rowid }}">{{ $category->label }}</a><span class="mx-2">/</span>
				</li>
			</ol>
		</nav>

		@if ($category->subcategories->isNotEmpty())
			<div class="my-2 p-2 rounded-lg bg-gray-300 h-64 overflow-x-auto flex flex-col flex-wrap">
				@foreach($category->subcategories as $subcategory)
					<div class="m-2 p-2 bg-white shadow-md">
						<a href="{{ route('products').'?category='.$subcategory->rowid }}" class="block">
							<h4 class="text-cdsolec-blue-light font-bold">{{ $subcategory->label }}</h4>
							<p class="text-xs">({{ $subcategory->products->count() }} Resultados)</p>
						</a>
					</div>
				@endforeach
			</div>
		@endif

		<div class="mt-3 grid gap-4 grid-cols-1 md:grid-cols-4 lg:grid-cols-5">
			<div class="relative">
				<div class="flex mb-3">
					<form method="GET" action="{{ route('products') }}" class="w-full">
						@csrf
						<label for="search" class="sr-only">Buscar</label>
						<div class="relative rounded-md shadow-sm">
							<input type="text" name="search" id="search2" value="{{ request('search', '') }}" class="block w-full pl-2 pr-12 text-sm rounded-md border border-cdsolec-green-dark focus:ring-gray-300 focus:border-gray-300" placeholder="Buscar" />
							<div class="absolute inset-y-0 right-0 flex items-center">
								<button type="submit" class="px-3 py-2 bg-cdsolec-green-dark rounded-r-md text-center text-white font-semibold uppercase tracking-wider hover:bg-cdsolec-green-light">
									<i class="fas fa-fw fa-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="mb-3">
					<a href="{{ route('products') }}?category={{ request()->category }}" class="px-3 py-2 block bg-cdsolec-green-dark rounded-md text-center text-white font-semibold uppercase tracking-wider hover:bg-cdsolec-green-light">Limpiar Filtros</a>
				</div>
				<div class="accordion text-sm">
					<div class="tab w-full overflow-hidden border-t mb-3 rounded-md shadow-md">
						<input type="checkbox" id="tab-one" name="filters" value="{{ request()->category }}" class="absolute opacity-0" />
						<label class="flex justify-between items-center p-2 cursor-pointer bg-gray-300 text-cdsolec-blue-light" for="tab-one">
							<div>Categorías</div> <i class="fas fa-fw fa-caret-down"></i>
						</label>
						<div class="tab-content overflow-hidden bg-gray-100 h-60 overflow-y-scroll">
							@if ($categories->isNotEmpty())
								<ul class="text-cdsolec-blue-light">
									@foreach($categories as $item)
										@php
											$bg = '';
											if (($item->rowid == $category->rowid) || 
													($category->parent && ($item->rowid == $category->parent->rowid))) {
												$bg = 'bg-cdsolec-green-light';
											}
										@endphp
										<li>
											<a href="{{ route('products') }}?category={{ $item->rowid }}&sector={{ request()->sector }}" class="px-2 py-1 block hover:bg-cdsolec-green-light {{ $bg }}">
												{{ $item->label }}
											</a>
											@if (($item->rowid == $category->rowid) || 
														($category->parent && ($item->rowid == $category->parent->rowid)))
												@if ($item->subcategories->isNotEmpty())
													<ul class="ml-2">
														@foreach($item->subcategories as $child)
															<li>
																<a href="{{ route('products') }}?category={{ $child->rowid }}&sector={{ request()->sector }}" class="px-2 py-1 block hover:bg-cdsolec-green-light {{ ($child->rowid == $category->rowid) ? 'bg-cdsolec-green-light' : '' }}">
																	<span class="fas fa-angle-right mr-1"></span> {{ $child->label }}
																</a>
															</li>
														@endforeach
													</ul>
												@endif
											@endif
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					</div>
					<!-- <div class="tab w-full overflow-hidden border-t mb-3 rounded-md shadow-md">
						<input type="checkbox" id="tab-two" name="filters" value="{{ request()->sector }}" class="absolute opacity-0" />
						<label class="flex justify-between items-center p-2 cursor-pointer bg-gray-300 text-cdsolec-blue-light" for="tab-two">
							<div>Sectores de Interés</div> <i class="fas fa-fw fa-caret-down"></i>
						</label>
						<div class="tab-content overflow-hidden bg-gray-100 h-60 overflow-y-scroll">
							@if ($sectors->isNotEmpty())
								<ul class="text-cdsolec-blue-light">
									@foreach($sectors as $item)
										@php
											$bg = '';
											if (($item->rowid == $category->rowid) || 
													($category->parent && ($item->rowid == $category->parent->rowid))) {
												$bg = 'bg-cdsolec-green-light';
											}
										@endphp
										<li>
											<a href="{{ route('products') }}?sector={{ $item->rowid }}&category={{ request()->category }}" class="px-2 py-1 block hover:bg-cdsolec-green-light {{ $bg }}">
												{{ $item->label }}
											</a>
											@if (($item->rowid == $category->rowid) || 
														($category->parent && ($item->rowid == $category->parent->rowid)))
												@if ($item->subcategories->isNotEmpty())
													<ul class="ml-2">
														@foreach($item->subcategories as $child)
															<li>
																<a href="{{ route('products') }}?sector={{ $child->rowid }}&category={{ request()->category }}" class="px-2 py-1 block hover:bg-cdsolec-green-light {{ ($child->rowid == $category->rowid) ? 'bg-cdsolec-green-light' : '' }}">
																	<span class="fas fa-angle-right mr-1"></span> {{ $child->label }}
																</a>
															</li>
														@endforeach
													</ul>
												@endif
											@endif
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					</div> -->
					@if ($extrafields->isNotEmpty())
						@foreach ($extrafields as $extrafield)
							@if (isset($attributes[$extrafield->name]) && isset($attributes[$extrafield->name.'f']) && $attributes[$extrafield->name.'f'])
								<div class="tab w-full overflow-hidden border-t mb-3 rounded-md shadow-md">
									<input type="checkbox" id="tab-{{ $loop->iteration }}" name="filters" class="absolute opacity-0" />
									<label class="flex justify-between items-center p-2 cursor-pointer bg-gray-300 text-cdsolec-blue-light" for="tab-{{ $loop->iteration }}">
										<div>{{ $attributes[$extrafield->name] }}</div> <i class="fas fa-fw fa-caret-down"></i>
									</label>
									<div class="tab-content overflow-hidden bg-gray-100 h-60 overflow-y-scroll">
										@php
											$unique = $matriz->unique($extrafield->name);
											$values = $unique->sortBy($extrafield->name)->values()->all();
										@endphp
										@if (count($values) > 0)
											<ul class="text-cdsolec-blue-light">
												@foreach ($values as $value)
													@php
														$checked = '';
														if (isset($filters[$extrafield->name])) {
															if (in_array($value[$extrafield->name], $filters[$extrafield->name])) {
																$checked = 'checked';
															}
														}
													@endphp
													<li class="px-2 py-1 hover:bg-cdsolec-green-light">
														<input type="checkbox" data-filter="{{ $extrafield->name }}" name="{{ $extrafield->name }}[]" onclick="handleCheck()" id="{{ $extrafield->name }}_{{ $loop->iteration }}" class="checkfilter border border-cdsolec-green-dark rounded text-cdsolec-green-dark shadow-sm focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50" value="{{ $value[$extrafield->name] }}" {{ $checked }} />
														{{ $value[$extrafield->name] }}
													</li>
												@endforeach
											</ul>
										@endif
									</div>
								</div>
							@endif
						@endforeach
					@endif
				</div>
			</div>
			<div class="relative md:col-span-3 lg:col-span-4">
				@if ($products->isNotEmpty())
					@php
						$cart = session()->get('cart', []);
						$basket = session()->get('basket', []);
					@endphp
					<div class="rounded-lg bg-gray-300 overflow-x-auto flex flex-wrap relative h-[calc(100vh-10rem)] overflow-y-auto">
						<table id="products" class="relative w-full rounded-lg border-collapse border border-gray-300">
							<thead class="sticky top-0 bg-gray-300">
								<tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
									<th class="py-3" style="min-width: 80px">&nbsp;</th>
									<th class="py-3" style="min-width: 400px">Información</th>
									<th class="py-3" style="min-width: 120px">Disponiblidad</th>
									<th class="py-3" style="min-width: 140px">Precio</th>
									<th class="py-3" style="min-width: 140px">Cantidad</th>
									@if ($extrafields->isNotEmpty())
										@foreach ($extrafields as $extrafield)
											@if (isset($attributes[$extrafield->name]) && isset($attributes[$extrafield->name.'f']) && $attributes[$extrafield->name.'f'])
												<th class="py-3" style="min-width: 160px">{{ $attributes[$extrafield->name] }}</th>
											@endif
										@endforeach
									@endif
								</tr>
							</thead>
							<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
								@foreach ($products as $product)
									@php
										if (app()->environment('production')) {
											$image = null;
											$datasheet = null;
											if ($product->documents->isNotEmpty()) {
												$documents = $product->documents;
												$total = count($product->documents);
												$i = 0;
												while ((!$datasheet || !$image) && ($i < $total)) {
													if (!$datasheet && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'pdf')) {
														$datasheet = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
													}
													if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
														$image = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
													}
													$i++;
												}
											}

											if (!$image) { $image = 'img/favicon/apple-icon.png'; }
										} else {
											$image = 'img/favicon/apple-icon.png';
											$datasheet = null;
										}

										$product_fields = $product->extrafields->toArray();

										$stock = $product->stock - $product->seuil_stock_alerte;

										$price_original = $product->prices->where('price_level', 1)->first();
										$price_client = $product->prices->where('price_level', $price_level)->first();
										if ($price_client == null) {
											$price_client = $price_original;
										}
									@endphp
									<tr class="flex flex-col lg:table-row even:bg-gray-300">
										<td class="border border-gray-300 flex flex-row lg:table-cell">
											<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
												&nbsp;
											</div>
											<div class="p-2 flex">
												<img src="{{ asset($image) }}" alt="{{ $product->label }}" title="{{ $product->label }}" class="w-12 ml-2 img-zoomable" />
											</div>
										</td>
										<td class="border border-gray-300 flex flex-row lg:table-cell">
											<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
												Información
											</div>
											<div class="p-2">
												<a href="{{ route('product', $product->ref) }}" class="text-cdsolec-blue-light font-bold">
													{{ $product->label }}
												</a>
												<p>{{ $product_fields['at1'] }}</p>
												<p class="font-bold">Ref: {{ $product->ref }}</p>
												@if ($datasheet)
													<p>
														<a href="{{ $datasheet }}" target="_blank">
															<img class="h-5 w-5 inline" src="{{ asset('img/pdf.png') }}" alt="Datasheet" title="Datasheet" /> Descargar Datasheet
														</a>
													</p>
												@endif
											</div>
										</td>
										<td class="border border-gray-300 flex flex-row lg:table-cell">
											<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
												Disponibilidad
											</div>
											<div class="p-2 lg:text-center">
												@if ($stock > 0)
													Stock: {{ $stock }}
												@else
													<!-- <a href="{{ route('stock', $product->ref) }}" class="inline-block px-2 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-center" style="font-size: 0.7rem">
														Consultar
													</a> -->
													@if ((count($basket) > 0) && isset($basket[$product->rowid]))
														<form method="POST" action="{{ route('basket.destroy', $product->rowid) }}">
															@csrf
															@method('DELETE')
															<button type="submit" class="px-4 py-1 font-semibold bg-red-600 text-white uppercase text-xs">
																Eliminar <i class="fas fa-basket-arrow-down"></i>
															</button>
														</form>
													@else
														<form method="POST" action="{{ route('basket.store') }}">
															@csrf
															<input type="hidden" name="product" value="{{ $product->rowid }}" />
															<input type="hidden" name="quantity" value="1" />
															<button type="submit" class="px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
																Consultar
															</button>
														</form>
													@endif
												@endif
											</div>
										</td>
										<td class="border border-gray-300 flex flex-row lg:table-cell">
											<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
												Precio
											</div>
											<div class="p-2 lg:text-right">
												<p class="line-through text-red-600">$USD {{ number_format($price_original->price_discount, 2, ',', '.') }}</p>
												<p class="font-bold">$USD {{ number_format($price_client->price_discount, 2, ',', '.') }}</p>
												<p>Bs {{ number_format(($price_client->price_discount * $tasa_usd), 2, ',', '.') }}</p>
											</div>
										</td>
										<td class="border border-gray-300 flex flex-row lg:table-cell">
											<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
												Cantidad
											</div>
											<div class="p-2 text-center">
												@if ((count($cart) > 0) && isset($cart[$product->rowid]))
													<form method="POST" action="{{ route('cart.destroy', $product->rowid) }}">
														@csrf
														@method('DELETE')
														<button type="submit" class="px-4 py-1 font-semibold bg-red-600 text-white uppercase text-xs">
															Eliminar <i class="fas fa-cart-arrow-down"></i>
														</button>
													</form>
												@else
													<form method="POST" action="{{ route('cart.store') }}">
														@csrf
														<input type="hidden" name="product" value="{{ $product->rowid }}" />
														<div class="w-full flex pb-2">
															<button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
															<input type="number" name="quantity" id="quantity{{ $product->rowid }}" min="0" max="{{ $stock }}" step="1" data-stock="{{ $stock }}" value="0" class="w-16 text-right px-3" onchange="validateRange(this)" />
															<button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
														</div>
														@if ($stock > 0)
															<button type="submit" class="px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
																Agregar <i class="fas fa-shopping-cart"></i>
															</button>
														@else
															<button type="button" class="px-4 py-1 font-semibold bg-gray-500 text-white uppercase text-xs">
																Agregar <i class="fas fa-shopping-cart"></i>
															</button>
														@endif
													</form>
												@endif
											</div>
										</td>
										@if ($extrafields->isNotEmpty())
											@foreach ($extrafields as $extrafield)
												@if (isset($attributes[$extrafield->name]) && isset($attributes[$extrafield->name.'f']) && $attributes[$extrafield->name.'f'])
													<td class="border border-gray-300 flex flex-row lg:table-cell">
														<div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
															{{ $attributes[$extrafield->name] }}
														</div>
														<div class="p-2 lg:text-right">
															<p>{{ $product_fields[$extrafield->name] }}</p>
														</div>
													</td>
												@endif
											@endforeach
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="mt-4 text-right">
						{{ $products->links() }}
					</div>
				@else
					<div class="w-full px-3 py-2 rounded border border-blue-600 bg-blue-200 text-blue-600 text-sm font-bold">
						No hay productos disponibles
					</div>
				@endif
			</div>
      	</div>
    </div>
	@endsection

	@push('scripts')
		<script>
			function handleCheck() {
				let category = document.getElementById('tab-one').value;
				// let sector = document.getElementById('tab-two').value;
				let table = document.getElementById('products');
				// let tbody = table.getElementsByTagName('tbody')[0];
				let myCheckFilters = document.querySelectorAll(".checkfilter:checked");
				// let querystring = '?category=' + category + '&sector=' + sector;
				let querystring = '?category=' + category;
				let dataArray = [];

				myCheckFilters.forEach(item => {
					querystring = querystring + '&' + encodeURIComponent(item.dataset.filter) + '[]=' + encodeURIComponent(item.value);
				});

				let url = '/products' + querystring;

				location.href = url;
			}
		</script>
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
