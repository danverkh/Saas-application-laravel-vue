<div {{ $attributes->merge(['class' => 'max-w-screen-xl mx-auto w-full']) }}>
    <div class="h-full w-full py-12 px-6 xl:px-0">
        {{ $slot }}
    </div>
</div>
