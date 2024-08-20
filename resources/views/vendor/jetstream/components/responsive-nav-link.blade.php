@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-cdsolec-green-dark font-bold text-cdsolec-green-dark focus:outline-none focus:text-cdsolec-green-dark focus:border-cdsolec-green-dark transition'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent font-bold text-cdsolec-green-dark focus:outline-none focus:text-cdsolec-green-dark focus:border-cdsolec-green-dark transition hover:border-cdsolec-green-dark hover:text-cdsolec-green-dark hover:text-opacity-75';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
