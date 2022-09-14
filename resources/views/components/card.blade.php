@props([
    'title' => null,
    'buttons' => null,
    'titleSize' => 'text-xl',
    'bodyClass' => 'py-6',
])

<div {{ $attributes->merge(['class' => 'card w-full bg-base-100 shadow-lg rounded-xl']) }}>
    <div class="card-body {{ $bodyClass }}">
        @if ($title)
        <h2 class="card-title font-medium mb-3 {{ $titleSize }}">{{ $title }}</h2>
        @endif

        {{ $slot }}

        @if ($buttons)
        <div class="card-actions justify-end">
            {{ $buttons }}
        </div>
        @endif
    </div>
</div>
