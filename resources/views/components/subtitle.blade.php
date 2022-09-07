@props(['lineColor' => 'bg-primary'])

<h2 class="mb-16 text-5xl font-medium">
    <div class="relative inline-block text-zinc-900">
        {{ $slot }}
        <span class="absolute -bottom-5 left-0 h-[4px] transition-all duration-200 w-3/4 {{ $lineColor }}"></span>
    </div>
</h2>
