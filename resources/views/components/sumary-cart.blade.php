<div class="fixed top-0 right-0 bottom-0 w-60 bg-gray-300 overflow-y-auto" x-show="isCart" x-transition:enter="transition ease duration-700" x-transition:enter-start="opacity-0 transform scale-80" x-transition:enter-end="opacity-100 transform scale-100" @click.away="isCart = false">
	<div class="w-full flex flex-col">
		<div class="self-end">
			<button class="mx-1" @click="isCart = !isCart" title="Cerrar">
				<i class="fas fa-times fa-2x"></i>
			</button>
		</div>
		<div class="aa-cartbox-summary border border-gray-300 p-3 mt-1 bg-white z-10" >
			<ul>
				<li class="border-b border-gray-300 block float-left relative mb-2 pb-2 w-full">
					<div class="w-24 h-24 float-left mr-1">
						<img src="{{ asset('img/42.jpg')}}" alt="CD SOLEC" title="CD SOLEC" class="rounded-xl"/>
					</div>
					<div class="">
						<h4 class="mb-4 text-sm tracking-wider">
							<a href="">
								Producto 1
							</a>
						</h4>
						<p class="text-base text-cdsolec-green-dark">
						2 x 30$</p>
					</div>
				</li>
				<li class="border-b border-gray-300 block float-left relative mb-2 pb-2 w-full">
					<div class="w-24 h-24 float-left mr-1">
						<img src="{{ asset('img/42.jpg')}}" alt="CD SOLEC" title="CD SOLEC" class="rounded-xl"/>
					</div>
					<div class="">
						<h4 class="mb-4 text-sm tracking-wider">
							<a href="">
								Producto 1
							</a>
						</h4>
						<p class="text-base text-cdsolec-green-dark">
						2 x 30$</p>
					</div>
				</li>
				<li>
					<span class="float-left font-bold text-lg tracking-wider">
						Total
					</span>
					<span class="float-right font-bold text-lg tracking-wider">
						180$
					</span>
				</li>
			</ul>
		</div>
	</div>		
</div>