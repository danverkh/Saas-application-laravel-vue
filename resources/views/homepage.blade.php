<x-main-layout>
    @section('hero')
        <div class="relative">
            <div class="relative z-10 max-w-screen-xl px-16 xl:px-16 mx-auto mt-24 gap-10 pt-16 pb-20 lg:py-24 items-center flex flex-col md:flex-row">
                <div class="basis-1/2 flex flex-col justify-center items-start row-start-2 sm:row-start-1 md:pt-12">
                    <h1 class="text-6xl md:text-5xl lg:text-6xl leading-tight md:leading-[1.1] lg:leading-tight font-medium text-gray-900">
                        Get additional<br>
                        website <strong>visitors<span class="text-primary">.</span></strong>
                    </h1>

                    <p class="text-md md:text-sm lg:text-md text-gray-500/80 mt-4 mb-6 leading-loose md:leading-relaxed lg:leading-loose">
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
    @endsection

    <div class="bg-gray-50 border-t border-gray-200 px-6 sm:px-8 xl:px-20 rounded-lg -mb-14">
        <div class="max-w-screen-xl mx-auto pt-16 pb-32">
            <div class="lg:w-[75%] mx-auto flex sm:flex-nowrap items-end gap-5 md:gap-6">
                <market-select class="grow-0"></market-select>

                <div class="flex-1">
                    <label class="block text-gray-500 mb-2">Domain / Keyword</label>
                    <input type="text" placeholder="Please enter a domain or keyword here..." class="input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-8 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>
                </div>

                <div class="grow-0">
                    <button class="btn btn-lg no-animation gap-2 tracking-widest bg-gray-900 h-[62px] min-h-[62px] group md:px-7">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 md:-ml-1 group-hover:scale-110 transition-all">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="md:ml-1 hidden md:inline">Search</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl px-6 sm:px-8 xl:px-16 mx-auto">
        <div class="bg-primary hover:bg-primary-hover transition-colors duration-500 lg:w-[75%] mx-auto text-white-300 px-10 sm:px-20 py-5 sm:py-7 rounded-full flex flex-nowrap flex-col md:flex-row md:gap-5 items-center border-b-red-700 border-b-4">
            <div class="text-xl basis-2/3 leading-9 text-center md:text-right">Only pay when you receive additional website visitors and customers from us.</div>
            <div class="divider divider-vertical md:divider-horizontal mt-3 mb-1"></div>
            <div class="basis-1/3 font-semibold text-center md:text-left">
                <div class="md:whitespace-nowrap inline md:block text-3xl md:text-3xl">It's free until it</div>
                <span class="text-4xl md:text-6xl text-gray-900 ml-3 md:ml-0">works.</span>
            </div>
        </div>
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
