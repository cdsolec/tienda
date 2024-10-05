@php
    if (app()->environment('production')) {
        $image = null;
        $datasheet = null;
        if ($product->documents->isNotEmpty()) {
            $documents = $product->documents;
            $total = count($product->documents);
            $i = 0;
            while ((!$datasheet || !$image) && ($i < $total)) {
                if (!$datasheet && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'pdf')) {
                    $datasheet = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
                }
                if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
                    $image = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
                }
                $i++;
            }
        }

        if (!$image) { $image = 'img/favicon/apple-icon.png'; }
    } else {
        $image = 'img/favicon/apple-icon.png';
        $datasheet = null;
    }

    $product_fields = $product->extrafields->toArray();

    $stock = $product->stock - $product->seuil_stock_alerte;
    $inTransit = $stockInTransit[$product->rowid]??null;

    $price_original = $product->prices->where('price_level', 1)->first();
    $price_client = $product->prices->where('price_level', $price_level)->first();
    if ($price_client == null) {
        $price_client = $price_original;
    }
@endphp
<tr class="p{{$product->rowid}} flex flex-col lg:table-row @if($loop->iteration%2==0) bg-gray-300 @else  bg-white @endif  ">
    <td class="border border-gray-300 flex flex-row lg:table-cell ">
        <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
            &nbsp;
        </div>
        <div class="p-2 flex">
            <img src="{{ asset($image) }}" alt="{{ $product->label }}" title="{{ $product->label }}" class="w-12 ml-2 img-zoomable" />
        </div>
    </td>
    <td class="border border-gray-300 flex flex-row lg:table-cell sticky left-0 @if($loop->iteration%2==0) bg-gray-300 @else  bg-white @endif">
        <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
            Información
        </div>
        <div class="p-2">
            <a href="{{ route('product', $product->ref) }}" class="text-cdsolec-blue-light font-bold">
                {{ $product->label }}
            </a>
            <p>{{ $product_fields['at1'] }}</p>
            <p class="font-bold">Ref: {{ $product->ref }}</p>
            @if ($datasheet)
                <p>
                    <a href="{{ $datasheet }}" target="_blank">
                        <img class="h-5 w-5 inline" src="{{ asset('img/pdf.png') }}" alt="Datasheet" title="Datasheet" /> Descargar Datasheet
                    </a>
                </p>
            @endif
        </div>
    </td>
    <td class="tdDisponibilidad border border-gray-300 flex flex-row lg:table-cell">
        <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
            Disponibilidad
        </div>
        <div class="p-2 lg:text-center">
            
            @if ($stock > 0)
                Stock: {{ $stock }}
                <form method="POST" action="{{ route('basket.store') }}">
                    @csrf
                    <input type="hidden" name="product" value="{{ $product->rowid }}" />
                    <input type="hidden" name="quantity" value="1" />
                    <button type="submit" class="px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
                        Consultar
                    </button>
                </form>
            @else
                <!-- <a href="{{ route('stock', $product->ref) }}" class="inline-block px-2 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-center" style="font-size: 0.7rem">
                    Consultar
                </a> -->
                @if ((count($basket) > 0) && isset($basket[$product->rowid]))
                    <form method="POST" action="{{ route('basket.destroy', $product->rowid) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-1 font-semibold bg-red-600 text-white uppercase text-xs">
                            Eliminar <i class="fas fa-basket-arrow-down"></i>
                        </button>
                    </form>

                    <p> Basket: {{$basket[$product->rowid]}} </p>
                @else
                    <form method="POST" action="{{ route('basket.store') }}">
                        @csrf
                        <input type="hidden" name="product" value="{{ $product->rowid }}" />
                        <input type="hidden" name="quantity" value="1" />
                        <button type="submit" class="px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
                            Consultar
                        </button>
                    </form>
                @endif
            @endif
            @if($inTransit)<p>En Transito: {{$inTransit??0}}</p>@endif
        </div>
    </td>
    <td class="border border-gray-300 flex flex-row lg:table-cell">
        <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
            Precio
        </div>
        <div class="p-2 lg:text-right">
            @if($isLogged)
                <p  class="line-through text-red-600">$USD {{ number_format($price_original->price_discount, 2, ',', '.') }}</p>
            @endif
            <p class="font-bold">$USD {{ number_format($price_client->price_discount, 2, ',', '.') }}</p>
            <p>Bs {{ number_format(($price_client->price_discount * $tasa_usd), 2, ',', '.') }}</p>
        </div>
    </td>
    <td class="border border-gray-300 flex flex-row lg:table-cell">
        <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
            Cantidad
        </div>
        <div class="p-2 text-center">
            <form method="POST" id="p{{ $product->rowid }}" action="{{ route('cart.store') }}">
                @csrf
                <input type="hidden" name="product" value="{{ $product->rowid }}" />
                <div class="w-full flex pb-2">
                    <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="decrement">-</button>
                    <input type="number" name="quantity" id="quantity{{ $product->rowid }}" min="1" max="{{ $stock }}" step="1" data-stock="{{ $stock }}" value="1" class="w-16 text-right px-3" onchange="validateRange(this)" />
                    <button type="button" class="px-3 py-2 border border-gray-500 font-semibold" data-action="increment">+</button>
                </div>
                @if ($stock > 0)
                    <button type="button" data-id="{{ $product->rowid }}" class=" addToCart  px-4 py-1 font-semibold bg-cdsolec-green-dark text-white uppercase text-xs">
                        @if ((count($cart) > 0) && isset($cart[$product->rowid]))
                           <span class="detalleBotonCart-{{ $product->rowid }}">Actualizar</span>  <i class="fas fa-shopping-cart"></i>
                        @else
                            <span class="detalleBotonCart-{{ $product->rowid }}">Agregar</span> <i class="fas fa-shopping-cart"></i>
                        @endif
                        
                    </button>
                @else
                    <button type="button" class=" disabled px-4 py-1 font-semibold bg-gray-500 text-white uppercase text-xs">
                        Agregar <i class="fas fa-shopping-cart"></i>
                    </button>
                @endif
            </form>

            @if ((count($cart) > 0) && isset($cart[$product->rowid]))
                <a class="detalle-{{ $product->rowid }}" href="{{'/cart'}}"><span class="detalle-{{ $product->rowid }}">{{$cart[$product->rowid]['quantity']}}</span>  en el Carrito </a>
            @else
            <a class="detalle-{{ $product->rowid }}" href="{{'/cart'}}"></a>
            @endif
        </div>
    </td>
    @if ($extrafields->isNotEmpty())
        @foreach ($extrafields as $extrafield)
            @if (isset($attributes[$extrafield->name]) && isset($attributes[$extrafield->name.'f']) && $attributes[$extrafield->name.'f'])
                <td class="border border-gray-300 flex flex-row lg:table-cell">
                    <div class="p-2 w-32 lg:hidden bg-gray-300 text-sm leading-4 tracking-wider font-bold">
                        {{ $attributes[$extrafield->name] }}
                    </div>
                    <div class="p-2 lg:text-right">
                        <p>{{ $product_fields[$extrafield->name] }}</p>
                    </div>
                </td>
            @endif
        @endforeach
    @endif
</tr>