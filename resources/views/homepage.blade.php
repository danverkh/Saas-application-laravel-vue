<x-main-layout>
    <div class="relative">
        <div class="relative z-10 max-w-screen-xl px-6 py-24 mx-auto gap-10 items-center flex flex-col md:flex-row">
            <div class="basis-1/2 flex flex-col justify-center items-start row-start-2 sm:row-start-1 md:pt-12">
                <h1 class="text-6xl md:text-5xl lg:text-6xl leading-tight md:leading-[1.1] lg:leading-tight font-medium text-gray-900">
                    Get additional<br>
                    website <strong>visitors<span class="text-primary">.</span></strong>
                </h1>

                <p class="text-md md:text-sm lg:text-md xl:text-lg text-gray-500/80 mt-4 mb-6 leading-loose md:leading-relaxed lg:leading-loose xl:leading-relaxed">
                    Get additional website visitors and conversions from search engines.<br class="hidden lg:block"/>
                    Pay only for traffic you receive.
                    It's like an ad campaign but for 10% of the price.
                </p>
            </div>

            <div class="basis-1/2 shadow-strong rounded-xl overflow-hidden bg-gray-200 border-2 border-zinc-300 w-full">
                <video-player image="/img/homepage_video.png" video="/video/homepage.mp4"/>
            </div>
        </div>

        <div id="hero-bg" class="absolute top-0 left-0 right-0 bottom-0 z-0 overflow-hidden"></div>
    </div>

    <div class="mb-16">
        <x-search-domain></x-search-domain>
    </div>

    {{--
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Test
        </h2>
    </x-slot>

    <div class="py-12">
        Test
    </div>--}}

    @push('script')
        <script src="/js/three.min.js"></script>
        <script src="/js/vanta.net.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                VANTA.NET({
                    el: "#hero-bg",
                    mouseControls: false,
                    touchControls: false,
                    gyroControls: false,
                    minHeight: 300.00,
                    minWidth: 800.00,
                    scale: 1.00,
                    scaleMobile: 1.00,
                    color: 0xFFB4BF,
                    backgroundColor: 0xffffff,
                    points: 5.00,
                    maxDistance: 75.00,
                    showDots: false,
                    spacing: 60.00,
                })
            });
        </script>
    @endpush
</x-main-layout>
