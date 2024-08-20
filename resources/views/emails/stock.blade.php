@component('mail::message')
# Consulta de Stock desde CD-SOLEC Web

Usted a recibido una consulta de stock con los siguientes datos:

Persona contacto: {{ $name }}

Email: {{ $email }}

Teléfono: {{ $phone }}

Producto: {{ $product_name }}

Ref: {{ $product_ref }}

Mensaje: 

{{ $message }}


{{ config('app.name') }}
@endcomponent
