<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-file mr-2 text-sm"></i> Contenidos
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span><a href="{{ route('contents.index') }}" class="text-cdsolec-green-dark">Contenidos</a></li>
				<li><span class="mx-2">/</span>Editar Contenido</li>
			</ol>
		</nav>

		<div class="flex flex-wrap justify-center">
			<div class="w-full lg:w-3/4 shadow rounded-md overflow-hidden bg-white">
				<div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 
				{{ ($errors->any()) ? 'block' : 'hidden' }}">
					<x-jet-validation-errors class="mb-4" />
				</div>

				<form id="form" name="form" method="POST" action="{{ route('contents.update', $content) }}" enctype="multipart/form-data">
					@csrf
					{{ method_field('PUT') }}

					@include("admin.contents.form")

					<div class="flex items-center justify-end px-4 py-3 bg-gray-200 text-right sm:px-6">
						<x-jet-button class="text-sm">
							<i class="fas fa-fw fa-save"></i> Actualizar
						</x-jet-button>
					</div>
				</form>
			</div>
		</div>
</x-dashboard-layout>