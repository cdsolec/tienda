<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-copyright"></i> Marcas
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span><a href="{{ route('brands.index') }}" class="text-cdsolec-green-dark">Marcas</a></li>
				<li><span class="mx-2">/</span>Agregar Marca</li>
			</ol>
		</nav>

		<div class="flex flex-wrap justify-center">
			<div class="w-full lg:w-3/4 shadow rounded-md overflow-hidden bg-white">
				<div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 
				{{ ($errors->any()) ? 'block' : 'hidden' }}">
				<x-jet-validation-errors class="mb-4" />
			</div>
			
			<form id="form" name="form" method="POST" action="{{ route('brands.store') }}" enctype="multipart/form-data">          
				@csrf

				@include("admin.brands.form")

			</form>

		</div>

	</div>

</x-dashboard-layout>
