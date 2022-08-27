@props(['active', 'with-color'])

@php
$classes = ($active ?? false)
            ? 'cursor-pointer animation-hover inline-block transition-colors underline-offset-4 text-primary decoration-solid hover:underline hover:text-primary-hover'
            : 'cursor-pointer animation-hover inline-block transition-colors underline-offset-4 text-black-500 decoration-solid hover:underline hover:text-primary-hover';

$classes .= ($withColor ?? true) ? ' text-primary' : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
