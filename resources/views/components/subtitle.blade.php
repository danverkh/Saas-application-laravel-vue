@props([
    'lineColor' => 'bg-primary',
    'line' => true,
    'textSize' => 'text-4xl xl:text-5xl',
    'lineHeight' => 'h-[4px]',
])

<h2 {{ $attributes->merge(['class' => 'mb-10 md:mb-12 font-medium ' . $textSize]) }}>
    <div class="relative inline-block text-zinc-900">
        {{ $slot }}

        @if($line)
            <span class="absolute -bottom-5 left-0 transition-all duration-200 w-3/4 max-w-[150px] {{ $lineColor }} {{ $lineHeight }}"></span>
        @endif
    </div>
</h2>
