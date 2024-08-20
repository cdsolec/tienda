<x-web-layout title="Nosotros">
	@section('background', asset('img/slide1.jpg'))

	@section('content')
    <div class="container mx-auto px-6">
			<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
				100% Capital venezolano
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">{{ $about->name }}</h2>
			{!! $about->description !!}
    </div>
	@endsection
</x-web-layout>