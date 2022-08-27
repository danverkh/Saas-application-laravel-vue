<x-main-layout>
    @section('hero')
        <div class="relative">
            <div class="relative z-10 max-w-screen-xl px-8 xl:px-16 mx-auto mt-24 grid grid-flow-row sm:grid-flow-col grid-rows-2 md:grid-rows-1 sm:grid-cols-2 gap-10 py-6 sm:py-24 ">
                <div class="flex flex-col justify-center items-start row-start-2 sm:row-start-1 pt-12">
                    <h1 class="text-3xl md:text-5xl lg:text-6xl lg:leading-tight font-medium text-black-600">
                        Get additional<br>
                        website <strong>visitors<span class="text-primary">.</span></strong>
                    </h1>

                    <p class="text-md text-gray-500/80 mt-4 mb-6 leading-loose">
                        Get additional website visitors and conversions from search engines.<br/>
                        Pay only for traffic you receive.
                        It's like an ad campaign but for 10% of the price.
                    </p>
                </div>

                <div class="shadow-strong">
                    <video-player image="https://media.vimejs.com/poster.png" video="https://media.vimejs.com/720p.mp4"/>
                </div>
            </div>

            <div id="hero-bg" class="absolute top-0 left-0 right-0 bottom-0 z-0"></div>
        </div>
    @endsection

    <div class="bg-primary w-[75%] mx-auto text-white-300 px-20 py-7 rounded-full flex flex-nowrap items-center border-b-red-700 border-b-4">
        <div class="text-2xl basis-2/3 leading-9">Only pay when you receive additional website visitors and customers from us.</div>
        <div class="text-3xl basis-1/3 font-semibold">It's free until it <span class="text-6xl text-gray-900">works.</span></div>
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
                    showDots: true,
                    spacing: 60.00,
                })
            });
        </script>
    @endpush
</x-main>
