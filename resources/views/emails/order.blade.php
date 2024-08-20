@component('mail::message')
# Compra {{ $commande->ref }}

Hemos recibido su compra con los siguientes datos:

**Cliente:** {{ $commande->society->nom }}<br />
**RIF:** {{ $commande->society->siren }}<br />
**Tlf:** {{ $commande->society->phone }}<br />
**Email:** {{ $commande->society->email }}

@component('mail::table')
| Producto | Cantidad | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Precio | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subtotal |
| -------- | --------:| -------------------------:| -------------------------:|
@foreach($commande->commande_detail as $item)
@php
$price_bs = $item->price * $commande->multicurrency_tx;
$subtotal_bs = $item->total_ht * $commande->multicurrency_tx;
@endphp
| {{ $item->description }}<br />Ref: {{ $item->label }} | {{ $item->qty }} | Bs {{ number_format($price_bs, 2, ',', '.') }}<br />$USD {{ number_format($item->price, 2, ',', '.') }} | Bs {{ number_format($subtotal_bs, 2, ',', '.') }}<br />$USD {{ number_format($item->total_ht, 2, ',', '.') }} |
@endforeach
@php
$total_bs = $commande->total_ht * $commande->multicurrency_tx;
@endphp
|          |          |                  Subtotal | Bs {{ number_format($total_bs, 2, ',', '.') }}<br />$USD {{ number_format($commande->total_ht, 2, ',', '.') }} |
@php
$iva_bs = $commande->tva * $commande->multicurrency_tx;
@endphp
|          |          |                       IVA | Bs {{ number_format($iva_bs, 2, ',', '.') }}<br />$USD {{ number_format($commande->tva, 2, ',', '.') }} |
@php
$total_bs = $total_bs + $iva_bs;
@endphp
|          |          |                 **Total** | **Bs {{ number_format($total_bs, 2, ',', '.') }}<br />$USD {{ number_format($commande->total_ttc, 2, ',', '.') }}** |
@endcomponent

**{{ config('app.name') }}**
@endcomponent
