<x-main-layout>
    <div class="mb-12">
        <div class="max-w-screen-xl px-6 py-14 mx-auto flex flex-col items-center">
            <h1 class="text-5xl font-bold text-zinc-900 mb-12">
                How it <span class="text-primary">works</span>
            </h1>

            <div class="shadow-strong rounded-xl overflow-hidden bg-gray-200 border-2 border-zinc-300 w-full max-w-3xl">
                <video-player image="/img/homepage_video.png" video="/video/homepage.mp4"/>
            </div>
        </div>
    </div>

    <div class="bg-primary py-8">
        <x-container class="text-white text-center text-lg leading-relaxed max-w-4xl">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci corporis exercitationem fugit iusto laborum laudantium quibusdam quos! Alias cum ducimus, enim fugit impedit non optio quod soluta tempore. Explicabo, qui.
        </x-container>
    </div>

    <div class="bg-white py-8">
        <x-container class="text-zinc-800 text-center text-lg leading-relaxed max-w-4xl">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci corporis exercitationem fugit iusto laborum laudantium quibusdam quos! Alias cum ducimus, enim fugit impedit non optio quod soluta tempore. Explicabo, qui.
        </x-container>
    </div>

    <x-search-keyword-or-domain></x-search-keyword-or-domain>

</x-main-layout>
