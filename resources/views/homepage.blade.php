@section('title', 'SEO User Signal Provider')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="relative">
        <div class="relative z-10 max-w-screen-xl px-6 py-24 mx-auto gap-10 items-center flex flex-col md:flex-row">
            <div class="basis-1/2 flex flex-col justify-center items-start row-start-2 sm:row-start-1 md:pt-12">
                <h1 class="text-6xl md:text-5xl lg:text-6xl leading-tight md:leading-[1.1] lg:leading-tight font-medium text-zinc-900">
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

    <div>
        <x-search-domain></x-search-domain>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="text-3xl md:text-5xl font-medium text-zinc-900 text-center mb-12 reveal scale-in">Why should you care</div>

        <div class="flex flex-col md:flex-row gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-end">
                <img src="/img/illustrations/chart_euro.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 leading-loose text-md md:text-xl text-center md:text-left mt-4 md:mt-0 text-zinc-500 reveal fade-in-right">
                Ads are too expensive. Total budget of seo agencies for keyword is probably greater then traffic value. There are no “organic” search results, people rank because
                they pay.
            </div>
        </div>
    </section>

    <div class="bg-zinc-100 py-8 md:py-12">
        <section class="max-w-screen-xl mx-auto text-center text-primary font-medium text-4xl md:text-5xl">
            Solution
        </section>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="flex flex-col md:flex-row-reverse gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-start">
                <img src="/img/illustrations/investment_data.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 text-center md:text-right mt-4 md:mt-0 reveal fade-in-right">
                <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">Only pay for Performance</div>
                <div class="leading-loose text-md md:text-xl text-zinc-500">Costs only for actual traffic received</div>
            </div>
        </div>
    </section>

    <div class="bg-zinc-100">
        <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
            <div class="flex flex-col md:flex-row gap-x-8 xl:gap-x-20">
                <div class="basis-1/2 flex justify-center md:justify-end">
                    <img src="/img/illustrations/lower_prices.svg" class="max-w-[170px] md:max-w-[200px] h-auto reveal fade-in-left">
                </div>
                <div class="basis-1/2 text-center md:text-left mt-4 md:mt-0 reveal fade-in-right">
                    <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">Lower prices</div>
                    <div class="leading-loose text-md md:text-xl text-zinc-500">Lower traffic acquisition costs than other channels</div>
                </div>
            </div>
        </section>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="flex flex-col md:flex-row-reverse gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-start">
                <img src="/img/illustrations/social.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 text-center md:text-right mt-4 md:mt-0 reveal fade-in-right">
                <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">Bare-minimum customer service</div>
                <div class="leading-loose text-md md:text-xl text-zinc-500">
                    We do only offer minimum of service/consulting but focus only on getting you traffic.
                    This leads to lower prices for you if you do not need service/consulting.
                </div>
            </div>
        </div>
    </section>

    <div class="bg-zinc-100">
        <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
            <div class="flex flex-col md:flex-row gap-x-8 xl:gap-x-20">
                <div class="basis-1/2 flex justify-center md:justify-end">
                    <img src="/img/illustrations/data.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
                </div>
                <div class="basis-1/2 mt-4 md:mt-0 reveal fade-in-right">
                    <div class="text-2xl md:text-3xl text-center md:text-left font-medium text-zinc-900 mb-5">Work with the best data</div>
                    <div class="leading-loose text-md md:text-lg text-zinc-500">
                        <ul class="red-dots">
                            <li>Most people user SEO tools to get keyword data, which is often outdated</li>
                            <li>We directly integrate with the <a href="https://developers.google.com/google-ads/api/docs/start">Google Ads API Endpoint</a> to get you the best
                                data to improve decisionmaking
                            </li>
                            <li>Lower traffic acquisition costs than other channels</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="flex flex-col md:flex-row-reverse gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-start">
                <img src="/img/illustrations/campaigns.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 text-center md:text-right mt-4 md:mt-0 reveal fade-in-right">
                <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">The best performance in the market</div>
                <div class="leading-loose text-md md:text-xl text-zinc-500">
                     Look at hundreds of successful campaigns
                </div>
            </div>
        </div>
    </section>

    <div class="bg-zinc-100">
        <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
            <div class="flex flex-col md:flex-row gap-x-8 xl:gap-x-20">
                <div class="basis-1/2 flex justify-center md:justify-end">
                    <img src="/img/illustrations/gift.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
                </div>
                <div class="basis-1/2 text-center md:text-left mt-4 md:mt-0 reveal fade-in-right">
                    <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-5">Free bonus items for you</div>
                    <div class="leading-loose text-md md:text-xl text-zinc-500">
                        as an AutoRanker customer you get free things like AutoSuggest keywords or offers from agencies for website analysis (your data is not shared)
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="flex flex-col md:flex-row-reverse gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-start">
                <img src="/img/illustrations/dashboard.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 text-center md:text-right mt-4 md:mt-0 reveal fade-in-right">
                <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">View Campaign in Dashboard</div>
                <div class="leading-loose text-md md:text-xl text-zinc-500">
                    Always view all stats in your dashboard
                </div>
            </div>
        </div>
    </section>

    <div class="bg-zinc-100">
        <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
            <div class="flex flex-col md:flex-row gap-x-8 xl:gap-x-20">
                <div class="basis-1/2 flex justify-center md:justify-end">
                    <img src="/img/illustrations/email.svg" class="max-w-[200px] md:max-w-[250px] h-auto reveal fade-in-left">
                </div>
                <div class="basis-1/2 text-center md:text-left mt-4 md:mt-0 reveal fade-in-right">
                    <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-5">E-Mail reportings</div>
                    <div class="leading-loose text-md md:text-xl text-zinc-500">
                        We send out a lot of emails with updates regarding your campaign
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="max-w-screen-xl mx-auto px-6 py-14 md:py-20">
        <div class="flex flex-col md:flex-row-reverse gap-x-8 xl:gap-x-20">
            <div class="basis-1/2 flex justify-center md:justify-start">
                <img src="/img/illustrations/ml.svg" class="max-w-[260px] md:max-w-[320px] h-auto reveal fade-in-left">
            </div>
            <div class="basis-1/2 text-center md:text-right mt-4 md:mt-0 reveal fade-in-right">
                <div class="text-2xl md:text-3xl font-medium text-zinc-900 mb-3">Compliance built-in</div>
                <div class="leading-loose text-md md:text-xl text-zinc-500">
                    We automatically check content of websites promoted using machine learning. This leads to quicker approvals of campaigns and lower costs
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script src="/js/three.min.js"></script>
        <script src="/js/vanta.net.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                window.scrollObserver('.reveal', {once: true, threshold: 0.5});

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
                });
            });
        </script>
    @endpush
</x-main-layout>
