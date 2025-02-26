<x-web-layout title="{{ $category->label }}">
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
	@section('title',  $category->label)
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
			<div class="my-2 p-2 rounded-lg bg-gray-300 ">
				<h3 class="w-full   p-2">Subcategorias</h3>
				<div class="  max-h-64  overflow-x-auto flex flex-col flex-wrap">
					@foreach($category->subcategories as $subcategory)
						<div class="m-2 p-2 bg-white shadow-md">
							<a href="{{ route('products').'?category='.$subcategory->rowid }}" class="block">
								<h4 class="text-cdsolec-blue-light font-bold">{{ $subcategory->label }}</h4>
								<p class="text-xs">({{ $subcategory->products->count() }} Resultados)</p>
							</a>
						</div>
					@endforeach
				</div>
				
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
				<div class="flex flex-col">
					
					<div class="">
						<div id="doublescroll" class="rounded-lg bg-gray-300 overflow-x-auto flex flex-wrap relative h-[calc(100vh-10rem)] overflow-y-auto">
							<table id="products" class="relative w-full rounded-lg border-collapse border border-gray-300">
								<thead class="sticky top-0 bg-gray-300">
									<tr class="hidden lg:table-row text-sm leading-4 tracking-wider ">
										<th class="py-3 " style="min-width: 80px">&nbsp;</th>
										<th class="py-3 sticky left-0  bg-gray-300" style="min-width: 400px">Información de producto</th>
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
										@include('web.productDetail')
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
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
			function DoubleScroll(element) {
				/*
				We start with this:
				<element>
					<firstElementChild>
					.
					</firstElementChild>
				</element>


				We end up with this:
				<element>
					<scroll1>
						<scroll1Inner></scroll1>
					</scroll1>
					<scroll2>
						<firstElementChild>
						.
						</firstElementChild>
					</scroll2>
				</element
				*/

				let scroll1 = document.createElement('div');
				scroll1.classList.add('doublescroll1');
				scroll1.style.overflowX = 'auto';
				scroll1.style.overflowY = 'hidden';
				scroll1.style.marginTop = '-1px';

				let scroll1Inner = document.createElement('div');
				scroll1Inner.classList.add('doublescroll-inner');
				scroll1Inner.style.paddingTop = '1px';
				scroll1Inner.style.width = element.firstElementChild.scrollWidth+'px';

				scroll1.appendChild(scroll1Inner);

				let scroll2 = document.createElement('div');
				scroll2.classList.add('doublescroll2');
				scroll2.style.overflowX = 'auto';

				// Move the element's first node inside the scroll2 div
				scroll2.appendChild(element.firstElementChild);
				
				element.appendChild(scroll1);
				element.appendChild(scroll2);

				let isRunning = false;

				scroll1.onscroll = function() {
					if (isRunning) {
						isRunning = false;
						return;
					}

					isRunning = true;
					scroll2.scrollLeft = scroll1.scrollLeft;
				};

				scroll2.onscroll = function() {
					if (isRunning) {
						isRunning = false;
						return;
					}
					
					isRunning = true;
					scroll1.scrollLeft = scroll2.scrollLeft;
				};
			}




			var urlAddToCart = "{{route('cart.addtocart')}}";

			DoubleScroll(document.getElementById('doublescroll'));

			$(document).ready(function(){
				$(document).on('click', '.addToCart', function(e){

				//	alert('click');
				
					product=$(this).data('id');
					quantity = $('#quantity'+product+'').val();

					$.ajax({
						type: 'Post',
						data: {product, quantity},
						url: urlAddToCart,
						success: function(data) {
							//console.log(data);
							if(!data.data.error){
								$('.detalle-'+product+'').html(quantity+' en el Carrito');
								const longitudDesdeJSON = Object.keys(data.data).length;
							//	console.log(longitudDesdeJSON);
								$('.cartCount').html(longitudDesdeJSON);
								$('.detalleBotonCart-'+product+'').html('Actualizar');
								
							}
						}
					});
					
				})
			})

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
