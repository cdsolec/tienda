<x-web-layout title="Nosotros">
	@section('background', asset('img/slide1.jpg'))

	@section('content')
    <div class="container mx-auto px-6">
			<h2 class="text-3xl leading-tight font-bold mt-4">{{ $policy->name }}</h2>
			{!! $policy->description !!}
    </div>
	@endsection
</x-web-layout>