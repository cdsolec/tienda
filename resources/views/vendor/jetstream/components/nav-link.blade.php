@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-4 border-cdsolec-green-dark text-cdsolec-green-dark text-sm font-bold leading-5 tracking-wide uppercase focus:outline-none focus:border-cdsolec-green-light transition'
            : 'inline-flex items-center px-1 pt-1 border-b-4 border-transparent text-cdsolec-green-dark text-sm font-bold leading-5 tracking-wide uppercase focus:outline-none focus:border-cdsolec-green-light transition hover:border-cdsolec-green-dark hover:text-opacity-75';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
