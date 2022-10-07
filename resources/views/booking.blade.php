@section('title', 'Select keywords')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <preview-rank-modal></preview-rank-modal>

    <x-container>
        <div class="max-w-screen-xl mx-auto mb-8">
            <div id="slider-container" class="flex-col flex flex-nowrap gap-8 xl:flex-row">
                <div id="content" class="content w-full xl:w-9/12 flex flex-col gap-6">
                    <x-card class="border-t-4 border-primary gap-0">
                        <div class="flex flex-nowrap gap-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-20 h-20 text-primary min-w-[60px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                            </svg>

                            <div class="xl:pr-20">
                                <h4 class="text-2xl font-medium mb-2 text-zinc-800">Please select keywords</h4>
                                <p class="text-sm text-zinc-400">
                                    From the list below, select keywords which you think a potential customer
                                    <br class="hidden xl:block">
                                    of your services would be searching.
                                </p>
                            </div>
                        </div>

                        <div class="divider divider-vertical my-0"></div>

                        <div class="flex gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-primary ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                            There are no costs for you until you receive traffic for these keywords.
                        </div>
                    </x-card>

                    <div class="bg-white shadow-lg rounded-2xl">
                        <rankings-table market="{{ $market }}" domain="{{ $domain }}"></rankings-table>
                    </div>
                </div>

                <!-- Aside -->
                <div id="sidebar" class="sidebar w-full xl:w-3/12">
                    <div class="sidebar__inner flex flex-col gap-6 md:block md:columns-2 md:space-y-6 xl:flex xl:columns-1 xl:space-y-0">
                        <x-card class="md:order-1 xl:order-3 border-t-4 border-zinc-300">
                            <h4 class="-mt-2 font-medium text-xl">Forecasted Results</h4>

                            <div class="divider divider-vertical my-0"></div>

                            <forecasted-results></forecasted-results>

                            <div class="text-sm -mb-6 -mx-8 pt-4 pb-5 px-8 bg-zinc-50 text-zinc-500">
                                Forecasted results are directional estimates and do not guarantee performance.
                                <a href="#" class="text-primary hover:underline whitespace-nowrap">Learn more</a>
                            </div>
                        </x-card>

                        <x-card class="md:order-3 xl:order-4 border-t-4 border-zinc-300">
                            <h4 class="-mt-2 font-medium text-md">Campaign Progress Prediction</h4>

                            <div class="divider divider-vertical my-0"></div>

                            <campaign-progress-prediction-chart></campaign-progress-prediction-chart>
                        </x-card>

                        <x-card class="md:order-2 xl:order-2 border-t-4 border-zinc-300">
                            <domain-switcher market="{{ $market }}" domain="{{ $domain }}"></domain-switcher>
                        </x-card>

                        <checkout class="md:order-4 xl:order-1"></checkout>
                    </div>
                </div>
            </div>
        </div>
    </x-container>

    @push('script')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = new StickySidebar('#sidebar', {
                    topSpacing: 140,
                    bottomSpacing: 20,
                    containerSelector: '#slider-container',
                    innerWrapperSelector: '.sidebar-inner',
                    scrollContainer: '.drawer-content',
                    minWidth: 1279,
                });
            });
        </script>
    @endpush
</x-main-layout>
