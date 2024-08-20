@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full border border-cdsolec-green-dark focus:border-cdsolec-green-dark focus:ring focus:ring-cdsolec-green-light focus:ring-opacity-50 text-gray-800 rounded-md shadow']) !!} />
