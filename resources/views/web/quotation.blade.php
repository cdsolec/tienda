<x-web-layout title="Cotización">
	@push('styles')
		<style>
			/* Chrome, Safari, Edge, Opera */
			input::-webkit-outer-spin-button,
			input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}

			/* Firefox */
			input[type=number] {
				-moz-appearance: textfield;
			}
		</style>
	@endpush

	@section('background', asset('img/slide1.jpg'))

	@section('content')
		<div class="container mx-auto px-6">
			<h6 class="text-sm uppercase font-semibold tracking-widest text-blue-800">
				Detalle de su Cotización
			</h6>
			<h2 class="text-3xl leading-tight font-bold mt-4">Cotización</h2>

			<div class="mx-4 mt-5 text-sm text-red-800 p-2 rounded bg-red-300 border border-red-800 {{ ($errors->any()) ? 'block' : 'hidden' }}">
				<x-jet-validation-errors class="mb-4" />
			</div>
      
      <form id="form-quotation" name="form-quotation" method="POST" action="{{ route('quotation.checkout') }}">
        @csrf
        <div class="w-full py-3 mb-3" id="table">
          <table class="my-2 w-full rounded-lg overflow-hidden bg-white border-collapse border border-green-800">
            <thead class="border bg-gray-300">
              <tr class="hidden lg:table-row text-sm leading-4 tracking-wider">
                <th class="px-3 py-4 border-2 text-left">Código de Parte</th>
                <th class="px-3 py-4 border-2 text-left">Fabricante</th>
                <th class="px-3 py-4 border-2 text-center" style="width: 100px">Cantidad</th>
              </tr>
            </thead>
            <tbody class="w-full flex-1 sm:flex-none bg-white divide-y divide-gray-400 text-sm leading-5">
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo1" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante1" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity1" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo2" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante2" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity2" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo3" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante3" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity3" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo4" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante4" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity4" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo5" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante5" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity5" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo6" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante6" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity6" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo7" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante7" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity7" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo8" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante8" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity8" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo9" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante9" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity9" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
              <tr class="flex flex-col lg:table-row even:bg-gray-300">
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Código de Parte
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="codigo[]" id="codigo10" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Fabricante
                  </div>                         
                  <div class="px-3 py-2">
                    <input type="text" name="fabricante[]" id="fabricante10" />
                  </div>
                </td>
                <td class="flex flex-row lg:table-cell border-2 text-center">
                  <div class="w-32 md:w-40 px-3 py-2 bg-gray-500 text-white text-xs leading-4 font-medium uppercase tracking-wider table-row lg:hidden">
                    Cantidad
                  </div>                    
                  <div class="px-3 py-2 text-right">             
                    <div class="w-full flex pb-2">
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                      <input type="number" name="quantity[]" id="quantity10" min="0" step="1" value="1" class="w-16 text-right px-3" />
                      <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="flex justify-end">
          <button type="submit" class="bg-cdsolec-green-dark text-white rounded-lg px-3 py-2 hover:bg-cdsolec-green-light">
            Enviar <i class="fas fa-chevron-circle-right"></i>
          </button>
        </div>
      </form>
		</div>
	@endsection

	@push('scripts')
		<script>
			function decrement(e) {
				const btn = e.target.parentNode.parentElement.querySelector(
					'button[data-action="decrement"]'
				);
				const target = btn.nextElementSibling;
				let value = Number(target.value);
				value--;
				if (value < 1) value = 1;
				target.value = value;
			}

			function increment(e) {
				const btn = e.target.parentNode.parentElement.querySelector(
					'button[data-action="decrement"]'
				);
				const target = btn.nextElementSibling;
				let value = Number(target.value);
				value++;
				target.value = value;
			}

			const decrementButtons = document.querySelectorAll('button[data-action="decrement"]');
			const incrementButtons = document.querySelectorAll('button[data-action="increment"]');

			decrementButtons.forEach(btn => {
				btn.addEventListener("click", decrement);
			});

			incrementButtons.forEach(btn => {
				btn.addEventListener("click", increment);
			});
		</script>
	@endpush
</x-web-layout>