<x-web-layout title="Soluciones">
	@section('background', asset('img/slide1.jpg'))

	@section('content')
    <div class="container mx-auto px-6">
			<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
				Soluciones para la gestión de la energía eléctrica, automatización, digitalización y su conectividad.
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">{{ $solutions->name }}</h2>
			{!! $solutions->description !!}
			<h4 class="text-xl text-cdsolec-green-dark">
				<a href="{{ route('products').'?category='.$category->rowid }}" class="block mt-5 font-bold hover:text-cdsolec-green-dark">
					Soluciones
				</a>
			</h4>
			@if ($category->subcategories->isNotEmpty())
				<div class="grid gap-4 md:grid-cols-2">
					@foreach($category->subcategories as $subcategory)
						<div class="pl-5">
							<a href="{{ route('products').'?category='.$subcategory->rowid }}" class="block text-lg font-bold hover:text-cdsolec-green-dark">
								{{ $subcategory->label }}
							</a>
							@if ($subcategory->subcategories->isNotEmpty())
								<ul class="ml-5 list-disc">
									@foreach($subcategory->subcategories as $subcategory2)
										<li>
											<a href="{{ route('products').'?category='.$subcategory->rowid }}" class="block font-bold hover:text-cdsolec-green-dark">
												{{ $subcategory2->label }}
											</a>
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					@endforeach
				</div>
			@endif
    </div>
	@endsection
</x-web-layout>