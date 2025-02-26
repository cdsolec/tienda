<x-web-layout title="Contacto">
	@section('background', asset('img/slide3.jpg'))

	@section('title',  'Contacto')


	@section('content')
    <div class="container mx-auto px-6">
			<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
				Estamos aquí para servirte
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">{{ $contact->name }}</h2>
			<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ !session()->has('message') ? 'hidden' : '' }}>
				{{ session()->has('message') ? session()->get('message') : '' }}
			</div>
			<div class="mt-4 grid gap-3 grid-cols-1 md:grid-cols-2">
				<div class="w-full mb-3 pt-4">
					{!! $contact->description !!}
				</div>
				<div class="w-full mb-3">
					<form id="form-comment" method="POST" action="{{ route('comments.store') }}">
						@csrf
						<div class="w-full mb-3">
							<x-jet-label for="name" value="Nombre" class="sr-only" />
							<x-jet-input type="text" id="name" name="name" :value="old('name')" placeholder="Nombre" required />
							<x-jet-input-error for="name" class="mt-2" />
						</div>
						<div class="w-full mb-3">
							<x-jet-label for="email" value="Email" class="sr-only" />
							<x-jet-input type="email" id="email" name="email" :value="old('email', request('email'))" placeholder="Email" required />
							<x-jet-input-error for="email" class="mt-2" />
						</div>
						<div class="w-full mb-3">
							<x-jet-label for="phone" value="Teléfono" class="sr-only" />
							<x-jet-input type="text" id="phone" name="phone" :value="old('phone')" placeholder="Teléfono (xxx)-xxx-xxxx" pattern="^\(\d{3}\)-\d{3}-\d{4}$" required />
							<x-jet-input-error for="phone" class="mt-2" />
						</div>
						<div class="w-full mb-3">
							<x-jet-label for="message" value="Mensaje" class="sr-only" />
							<textarea name="message" cols="30" rows="5" class="form-textarea block w-full border border-cdsolec-green-dark focus:border-gray-300 focus:ring focus:ring-gray-300 focus:ring-opacity-50 text-gray-800 rounded-md shadow" placeholder="Mensaje" required>{{ old('message') }}</textarea>
							<x-jet-input-error for="message" class="mt-2" />
						</div>
						<div class="text-left">
							<x-jet-button type="submit">Enviar</x-jet-button>
						</div>
					</form>
				</div>
			</div>
    </div>
	@endsection

	@push('scripts')
		<script>
			(function() {
				'use strict';

				let phone = document.getElementById('phone');

				function formatTlf(e) {
					if ((this.value.length < 15) && ((e.keyCode > 47 && e.keyCode < 58) || (e.keyCode > 95 && e.keyCode <
							106))) {
						this.value = this.value.replace(/\(?(\d{3})\)?\-?(\d{3})\-?/, '($1)-$2-');
					} else {
						this.value = this.value.slice(0, -1);
					}
				}

				phone.addEventListener('keyup', formatTlf);
			})();
		</script>
	@endpush
</x-web-layout>