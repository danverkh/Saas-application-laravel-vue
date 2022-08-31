@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-primary hover:text-primary'
            : 'text-zinc-700 hover:text-primary';

$classes .= ' w-full cursor-pointer animation-hover inline-block transition-colors text-lg p-4 mb-3 active:bg-zinc-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
