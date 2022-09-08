@props(['lineColor' => 'bg-primary', 'line' => true])

<h2 {{ $attributes->merge(['class' => 'mb-10 md:mb-12 text-4xl xl:text-5xl font-medium']) }}>
    <div class="relative inline-block text-zinc-900">
        {{ $slot }}

        @if($line)
            <span class="absolute -bottom-5 left-0 h-[4px] transition-all duration-200 w-3/4 max-w-[150px] {{ $lineColor }}"></span>
        @endif
    </div>
</h2>
