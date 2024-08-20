@component('mail::message')
# Contacto desde CD-SOLEC Web

Usted a recibido un mensaje con los siguientes datos:

Persona contacto: {{ $comment->name }}

Email: {{ $comment->email }}

Teléfono: {{ $comment->phone }}

Mensaje: 

{{ $comment->message }}


**{{ config('app.name') }}**
@endcomponent
