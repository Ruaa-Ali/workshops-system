@props(['variant' => 'primary'])



@php

    $classes = match($variant) {
        'secondary' => ' secondary-btn',
        default => ' primary-btn'
    };
@endphp

<a {{ $attributes->merge(['class' => "btn $classes"]) }}>
    {{ $slot }}
</a>
