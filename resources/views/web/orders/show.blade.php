<x-dashboard-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-cdsolec-green-dark leading-tight uppercase">
			<i class="fas fa-shopping-cart"></i> Pedidos
		</h2>
	</x-slot>

	<div class="max-w-7xl mx-auto mb-14 mt-6 lg:mt-8 sm:px-6 lg:px-8">
		<nav class="mb-3 px-3 py-2 rounded bg-gray-200 text-gray-600">
			<ol class="flex flex-wrap">
				<li><a href="{{ route('dashboard') }}" class="text-cdsolec-green-dark"><i class="fas fa-home"></i></a></li>
				<li><span class="mx-2">/</span><a href="{{ route('orders.index') }}" class="text-cdsolec-green-dark">Pedidos</a></li>
				<li><span class="mx-2">/</span>Pedido</li>
			</ol>
		</nav>

		<div class="flex flex-wrap justify-center">
			<div class="w-full shadow rounded-md overflow-hidden bg-white px-4 py-3 sm:px-6">
				<div class="grid gap-2 md:grid-cols-4 items-end">
					<div class="col-span-3">
						<h2 class="text-3xl leading-tight font-bold mt-4">Pedido {{ $commande->ref }}</h2>
					</div>
					<div class="justify-self-end pb-2">
						<a href="{{ route('orders.pdf', $commande) }}" target="_blank" class="px-3 py-2 font-semibold uppercase text-sm text-white bg-green-600 hover:bg-green-500 tracking-wider rounded-md transition">
							<i class="fas fa-file-pdf"></i> Imprimir PDF
						</a>
					</div>
				</div>

				<div id="message" class="my-3 px-3 py-2 rounded border border-green-600 bg-green-200 text-green-600 text-sm font-bold" {{ (!session()->has('success')) ? 'hidden' : '' }}>
					{{ (session()->has('success')) ? session()->get('success') : '' }}
				</div>

				<div class="my-2 p-3 rounded-lg border bg-gray-300">
					<form action="{{ route('orders.name', $commande) }}" method="POST">
						@csrf
						<div class="grid gap-2 md:grid-cols-4">
							<div>								
								<x-jet-label for="name" value="Nombre del Proyecto:" class="font-bold text-xl" />
							</div>
							<div class="col-span-2">
								<x-jet-input type="text" id="name" name="name" value="{{ $commande->ref_client }}" placeholder="Nombre del proyecto:" required />
							</div>
							<div>
								<x-jet-button type="submit">Guardar</x-jet-button>
							</div>
						</div>
					</form>
				</div>

				<div class="w-full py-3 mb-3" id="table">
					<table class="my-2 w-full rounded-lg overflow-hidden bg-white border-collapse border border-green-800">
						<thead class="border bg-gray-300">
							<tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
								<th class="px-3 py-4 border-2 text-left">Producto</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 100px">Cantidad</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 200px">Precio</th>
								<th class="px-3 py-4 border-2 text-center" style="width: 220px">Sub-Total</th>
							</tr>
						</thead>
						<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
							@foreach($commande->commande_detail as $item)
								@php
									$price_bs = $item->price * $commande->multicurrency_tx;
									$subtotal_bs = $item->total_ht * $commande->multicurrency_tx;

									if (app()->environment('production')) {
										$image = null;
										if ($item->product->documents->isNotEmpty()) {
											$documents = $item->product->documents;
											$total = count($item->product->documents);
											$i = 0;
											while (!$image && ($i < $total)) {
												if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
													$image = 'storage/produit/'.$item->product->ref.'/'.$documents[$i]->filename;
												}
												$i++;
											}
										}

										if (!$image) { $image = 'img/favicon/apple-icon.png'; }
									} else {
										$image = 'img/favicon/apple-icon.png';
									}
								@endphp
								<tr class="flex flex-col lg:table-row even:bg-gray-300">
									<td class="flex flex-row lg:table-cell border-2">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Producto
										</div>                         
										<div class="px-3 py-2 lg:py-4 flex items-center">
											<div class="flex-shrink-0 h-10 w-10 mr-4">
												<img class="h-10 w-10 rounded-full" src="{{ asset($image) }}" alt="{{ $item->label }}" title="{{ $item->label }}" />
											</div>
											<div class="leading-5">
												<p class="text-sm text-cdsolec-blue-light font-bold">{{ $item->description }}</p>
												<p>Ref: {{ $item->label }}</p>
											</div>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Cantidad
										</div>                    
										<div class="px-3 py-2 lg:py-4 text-right">             
											{{ $item->qty }}
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Precio
										</div>
										<div class="px-3 py-2 lg:py-4 lg:text-right">
											<p>Bs {{ number_format($price_bs, 2, ',', '.') }}</p>
											<p>$USD {{ number_format($item->price, 2, ',', '.') }}</p>
										</div>
									</td>
									<td class="flex flex-row lg:table-cell border-2 text-center">
										<div class="w-32 md:w-40 px-3 py-2 lg:py-4 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
											Sub-Total
										</div>
										<div class="px-3 py-2 lg:py-4 lg:text-right">
											<p>
												Bs 
												<span id="subtotal_bs_{{ $item['id'] }}">
													{{ number_format($subtotal_bs, 2, ',', '.') }}
												</span>
											</p>
											<p>
												$USD 
												<span id="subtotal_usd_{{ $item['id'] }}">
													{{ number_format($item->total_ht, 2, ',', '.') }}
												</span>
											</p>
										</div>
									</td>
								</tr>
							@endforeach
							@php
								$total_bs = $commande->total_ht * $commande->multicurrency_tx;
							@endphp
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										SubTotal
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										SubTotal
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										SubTotal
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="subtotal_bs">
												{{ number_format($total_bs, 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="subtotal_usd">
												{{ number_format($commande->total_ht, 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
							</tr>
							@php
								$iva_bs = $commande->total_tva * $commande->multicurrency_tx;
							@endphp
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										IVA
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										IVA
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										IVA
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="iva_bs">
												{{ number_format($iva_bs, 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="iva_usd">
												{{ number_format($commande->total_tva, 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
							</tr>
							@php
								$total_bs = $total_bs + $iva_bs;
							@endphp
							<tr class="flex flex-col lg:table-row bg-gray-300">
								<td colspan="3" class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										Total
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										Total
									</div>
								</td>
								<td class="flex flex-row lg:table-cell border-2">
									<div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-bold uppercase tracking-wider table-row lg:hidden">
										Total
									</div>
									<div class="px-3 py-2 lg:text-right font-bold">
										<p>
											Bs 
											<span id="total_bs">
												{{ number_format($total_bs, 2, ',', '.') }}
											</span>
										</p>
										<p>
											$USD 
											<span id="total_usd">
												{{ number_format($commande->total_ttc, 2, ',', '.') }}
											</span>
										</p>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="my-2 p-3 rounded-lg border bg-gray-300">
					<div class="p-3 flex justify-between">
						<div>
							<p class="font-bold">Factura: {{ ($facture) ? $facture->ref : '' }}</p>
						</div>
						<div>
							<a href="{{ route('orders.payments.create', $commande) }}" class="mr-2 px-3 py-2 font-semibold uppercase text-sm text-white bg-cdsolec-green-dark hover:bg-cdsolec-green-light tracking-wider rounded-md transition">
								<i class="fas fa-dollar-sign"></i> Agregar Pago
							</a>
						</div>
					</div>
				</div>

				<table class="my-2 w-full rounded-lg overflow-hidden bg-white border-collapse border border-green-800">
					<thead class="border bg-gray-300">
						<tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
							<th class="px-3 py-4 border-2 text-center">Código</th>
							<th class="px-3 py-4 border-2 text-center" style="width: 220px">Referencia</th>
							<th class="px-3 py-4 border-2 text-center" style="width: 200px">Tipo</th>
							<th class="px-3 py-4 border-2 text-center" style="width: 120px">Fecha</th>
							<th class="px-3 py-4 border-2 text-center" style="width: 220px">Monto $USD</th>
						</tr>
					</thead>
					@if ($facture)
						@if ($facture->paiements->isNotEmpty())
							@php
								$total = 0;
							@endphp
							<tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
								@foreach ($facture->paiements as $paiement)
									@php
										$total += $paiement->amount;
									@endphp
									<tr>
										<td>{{ $paiement->ref }}</td>
										<td>{{ $paiement->num_paiement }}</td>
										<td>{{ $paiement->type->libelle }}</td>
										<td>{{ $paiement->datec->format('d/m/Y') }}</td>
										<td class="text-right">{{ number_format($paiement->amount, 2, ',', '.') }}</td>
									</tr>
								@endforeach
								<tr class="border bg-gray-300">
									<td colspan="4" class="text-right font-bold">Total $USD:</td>
									<td class="text-right font-bold">{{ number_format($total, 2, ',', '.') }}</td>
								</tr>
							</tbody>
						@endif
					@endif
				</table>
			</div>
		</div>
	</div>
</x-dashboard-layout>
