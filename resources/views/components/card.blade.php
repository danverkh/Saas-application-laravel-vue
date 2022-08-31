@props(['title' => null, 'buttons' => null])

<div {{ $attributes->merge(['class' => 'card w-full bg-base-100 shadow-lg rounded-xl']) }}>
    <div class="card-body py-6">
        @if ($title)
        <h2 class="card-title font-medium text-xl mb-3">{{ $title }}</h2>
        @endif

        {{ $slot }}

        @if ($buttons)
        <div class="card-actions justify-end">
            {{ $buttons }}
        </div>
        @endif
    </div>
</div>
