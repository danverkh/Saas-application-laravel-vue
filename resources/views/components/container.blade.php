<div {{ $attributes->merge(['class' => 'max-w-screen-xl mx-auto w-full']) }}>
    <div class="h-full w-full py-12">
        {{ $slot }}
    </div>
</div>
