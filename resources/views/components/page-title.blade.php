<div {{ $attributes->merge(['class' => 'mx-auto text-center text-5xl tracking-wider text-zinc-900 font-normal flex justify-center mb-4 lg:mb-8 xl:mb-12']) }}>
    <h1 class="text-4xl lg:text-5xl font-bold text-zinc-900">
        {{ $slot }}
    </h1>
</div>
