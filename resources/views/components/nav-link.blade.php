@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group relative w-max px-4 py-2 mx-2 cursor-pointer animation-hover inline-block transition-colors relative text-primary hover:text-primary'
            : 'group relative w-max px-4 py-2 mx-2 cursor-pointer animation-hover inline-block transition-colors relative text-black-500 hover:text-primary';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span>{{ $slot }}</span>
    <span class="absolute -bottom-1 left-1/2 w-0 -translate-x-1/2 opacity-0 transition-all duration-200 h-[2px] bg-primary group-hover:w-1/4 group-hover:opacity-75"></span>
</a>
