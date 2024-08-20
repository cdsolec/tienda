<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-file mr-2 text-sm"></i> Banners
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span><a href="{{ route('banners.index') }}" class="text-cdsolec-green-dark">Banners</a></li>
				<li><span class="mx-2">/</span>Papelera de Banners</li>
			</ol>
		</nav>

		<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ (!session()->has('message')) ? 'hidden' : '' }}>
			{{ session()->has('message') ? session()->get('message') : '' }}
		</div>

		<table class="my-3 w-full rounded-lg overflow-hidden shadow-md">
			<thead>
				<tr class="hidden lg:table-row bg-cdsolec-green-dark text-white text-sm leading-4 uppercase tracking-wider">
					<th style="width: 110px" class="px-3 py-3 font-medium text-center">
						ID
					</th>
					<th class="px-3 py-3 font-medium text-left">
						Banner
					</th>
					<th style="width: 120px" class="px-2 py-3 font-medium text-center">
						Fecha
					</th>
					<th style="width: 120px" class="px-3 py-3 font-medium text-center">
						Opciones
					</th>
				</tr>
			</thead>
			@if ($banners->isNotEmpty())
			<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
				@foreach($banners as $banner)
				<tr class="flex flex-col lg:table-row even:bg-gray-200">
					<td class="flex flex-row lg:table-cell">
						<div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
							ID
						</div>
						<div class="p-2 text-center text-sm">
							{{ str_pad($banner->id, 4, "0", STR_PAD_LEFT) }}
						</div>
					</td>
					<td class="flex flex-row lg:table-cell">
						<div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
							Banner
						</div>
						<div class="p-2 flex items-center">
							<img src="{{ asset($banner->url_image) }}" alt="{{ $banner->name }}" title="{{ $banner->name }}" class="h-16 mr-3" />
							<div>{{ $banner->name }}</div>
						</div>
					</td>
					<td class="flex flex-row lg:table-cell">
						<div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
							Fecha
						</div>
						<div class="p-2 text-center">
							{{ $banner->created_at->format('d/m/Y') }}
						</div>
					</td>
					<td class="flex flex-row lg:table-cell">
						<div class="p-2 w-32 lg:hidden bg-cdsolec-green-dark font-medium text-white text-sm leading-4 uppercase tracking-wider">
							Opciones
						</div>
						<div class="p-2 text-center">
							<a href="{{ route('banners.restore', $banner->id) }}" title="Restaurar" alt="Restaurar" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-blue-600 hover:bg-blue-500 tracking-wider rounded-md transition">
								<i class="fas fa-fw fa-sm fa-undo"></i>
							</a>
							@livewire('delete-modal', [
								'msg' => 'permanentemente este Banner',
								'model_id' => $banner->id,
								'route' => 'banners.delete',
								'method' => 'patch'
							])
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
			@endif
		</table>

		{{ $banners->links() }}
	</div>
</x-dashboard-layout>