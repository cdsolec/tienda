<x-web-layout title="Contacto">
	@section('background', asset('img/slide3.jpg'))

	@section('content')
    <div class="container mx-auto px-6">
		<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
			Distribuimos equipos y componentes de las mejores marcas
		</h6>
		<h2 class="text-3xl leading-tight font-bold mt-4">Fabricantes</h2>
		<div class="my-8 grid gap-4 grid-cols-3 md:grid-cols-5">
			@if ($brands->isNotEmpty())
				@foreach ($brands as $brand)
					@php
						if (app()->environment('production')) {
							$image = 'storage/societe/'.$brand->rowid.'/logos/'.$brand->logo;
						} else {
							$image = 'img/logos/CD-SOLEC-ICON.jpg';
						}
					@endphp
					<div class="brand border border-cdsolec-green-dark shadow-lg overflow-hidden sm:rounded-lg {{ ($loop->index > 4) ? 'transition duration-1000 ease-out opacity-0 transform scale-50' : '' }}">
						<a href="{{ route('products').'?at1[]='.$brand->nom }}">
							<img src="{{ asset($image) }}" alt="{{ $brand->nom }}" title="{{ $brand->nom }}" />
						</a>
					</div>
				@endforeach
			@endif
		</div>
    </div>
	@endsection

	@push('scripts')
		<script>
			(function() {
				'use strict';
			
				//------------------------  Brands  --------------------------
				const screen_position = window.innerHeight / 1.2;
				let brands = document.querySelectorAll('.brand');
			
				window.addEventListener('scroll', function() {
					//------------------------  Brands  ------------------------
					let brands_positions = [];
					for (let i = 0; i < brands.length; i++) {
						brands_positions[i] = brands[i].getBoundingClientRect().top;
			
						if (brands_positions[i] < screen_position) {
							brands[i].classList.remove('opacity-0');
							brands[i].classList.add('opacity-100');
							brands[i].classList.remove('scale-0');
							brands[i].classList.add('scale-100');
						}
					}
				});
				//------------------------------------------------------------
			})();
		</script>
	@endpush
</x-web-layout>