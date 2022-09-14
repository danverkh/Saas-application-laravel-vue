<div {{ $attributes->merge(['class' => 'mx-auto text-center text-5xl tracking-wider text-zinc-900 font-normal flex justify-center']) }}>
    <h1 class="text-4xl lg:text-5xl font-bold text-zinc-900 mb-4 lg:mb-8 xl:mb-12">
        {{ $slot }}
    </h1>
</div>
