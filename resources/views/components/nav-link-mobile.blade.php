@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'block px-3 py-2 rounded-md text-base font-medium bg-green-50 text-green-700'
            : 'block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>