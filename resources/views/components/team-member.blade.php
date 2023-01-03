@props([
    'image' => null,
    'name' => null,
    'position' => null,
    'description' => null,
    'twitter' => null,
    'facebook' => null,
])

<div class="grid sm:grid-cols-3">
    <div class="relative w-full h-40 max-h-full rounded shadow sm:h-auto">
        <img class="absolute object-cover w-full h-full rounded-lg border border-red-800/50 bg-zinc-800/10 outline-0 ring-red-800/50 shadow-lg transition duration-300 hover:shadow hover:ring-2" src="{{ $image }}" alt="{{ $name }}"/>
    </div>

    <div class="flex flex-col justify-center mt-5 sm:mt-0 sm:p-5 sm:col-span-2">
        <p class="text-xl font-bold text-zinc-100 mb-1">{{ $name }}</p>
        <p class="mb-4 text-md text-zinc-900 font-semibold">{{ $position }}</p>

        @if($description)
            <p class="mb-4 text-sm tracking-wide text-zinc-900">
                {{ $description }}
            </p>
        @endif

        <div class="flex items-center space-x-3">
            @if($twitter)
                <a href="{{ $twitter }}" class="text-zinc-900/60 transition-colors duration-300 hover:text-zinc-900">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                        <path d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"></path>
                    </svg>
                </a>
            @endif

            @if($facebook)
                <a href="{{ $facebook }}" class="text-zinc-900/60 transition-colors duration-300 hover:text-zinc-900">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                        <path d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"></path>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>
