@section('title', 'Dashboard')
@section('description', 'Here you can view your details')

<x-dashboard-layout>
    <cancel-keyword-confirmation></cancel-keyword-confirmation>

    <x-container class="mb-8">
        <div id="slider-container" class="flex-col flex flex-nowrap gap-6 xl:flex-row">
            <div id="sidebar" class="sidebar w-full z-10">
                <div class="sidebar__inner flex flex-col gap-6 md:block md:columns-2 md:space-y-6 xl:flex xl:columns-1 xl:space-y-0">
                    <x-card class="border-t-4 border-primary overflow-visible" bodyClass="px-5 py-3">
                        <div class="divide-y">
                            @foreach($orders->groupBy('domain') as $domain => $orders)
                                <div class="dropdown dropdown-right w-full py-2">
                                    <label tabindex="0" class="btn btn-secondary btn-block normal-case btn-ghost">
                                        {{ $domain }}
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 ml-3">
                                        @foreach($orders->pluck('keywords')->flatten() as $keyword)
                                        <li><a href="#">{{ $keyword->keyword }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                </div>
            </div>

            <div id="content" class="space-y-10">
                @foreach($orders->groupBy('domain') as $domain => $orders)
                    @foreach($orders->pluck('keywords')->flatten() as $keyword)
                    <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
                        <div class="flex justify-between w-full bg-zinc-300 py-3 md:py-4 px-5 md:px-7">
                            <div class="flex flex-col space-y-1 md:space-y-0 md:flex-row md:space-x-4">
                                <div>
                                    <div class="text-zinc-600 text-xs md:text-sm">Domain</div>
                                    <div class="text-zinc-800 text-xl md:text-2xl font-medium">{{ $domain }}</div>
                                </div>

                                <div class="divider divider-vertical md:divider-horizontal"></div>

                                <div>
                                    <div class="text-zinc-600 text-xs md:text-sm">Keyword</div>
                                    <div class="text-xl md:text-2xl font-medium text-primary">{{ $keyword->keyword }}</div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="bg-zinc-600">
                                        <svg class="w-6 h-6 cursor-pointer hover:text-zinc-900" width="32" height="32" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z"/>
                                        </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-3">
                                        <li>
                                            <button class="text-red-600" onclick="document.getElementById('cancel-keyword-confirmation').checked = true">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 cursor-pointer text-red-600" width="32" height="32" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/>
                                                </svg>
                                                Cancel keyword
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-zinc-200">
                            <div class="bg-accent inline-block px-5 py-6 text-white min-w-[150px]">
                                <div class="text-sm font-light flex">
                                    Clicks
                                    <svg class="w-3.5 h-3.5 mt-1 ml-1" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="m24 12l-8 10l-8-10z"/></svg>
                                </div>
                                <div class="text-3xl font-normal mt-1">672</div>
                            </div>

                            <div class="bg-primary inline-block px-5 py-6 text-white min-w-[150px]">
                                <div class="text-sm font-light flex">
                                    Impressions
                                    <svg class="w-3.5 h-3.5 mt-1 ml-1" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="m24 12l-8 10l-8-10z"/></svg>
                                </div>
                                <div class="text-3xl font-normal mt-1">4.32K</div>
                            </div>

                            <div class="inline-block px-5 py-6 text-zinc-800 min-w-[150px] border-r">
                                <div class="text-sm font-light flex">Avg. CPC</div>
                                <div class="text-3xl font-normal mt-1">€0.96</div>
                            </div>

                            <div class="inline-block px-5 py-6 text-zinc-800 min-w-[150px] border-r">
                                <div class="text-sm font-light flex">Cost</div>
                                <div class="text-3xl font-normal mt-1">€648</div>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-6 md:gap-10 p-6 md:p-10 pt-7">
                            <div class="w-full lg:w-1/2">
                                <div class="text-md md:text-xl font-medium text-zinc-700 text-center mb-2">Ranking improvement</div>
                                <ranking-improvement-chart></ranking-improvement-chart>
                            </div>

                            <div class="w-full lg:w-1/2">
                                <div class="text-md md:text-xl font-medium text-zinc-700 text-center mb-2">Estimated clicks & traffic</div>

                                <campaign-progress-prediction-chart
                                    value="{{ $keyword->keyword }}"
                                    :data='@json($keyword)'
                                    :options="{yAxis: true}"
                                ></campaign-progress-prediction-chart>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </x-container>

    @push('script')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = new StickySidebar('#sidebar', {
                    topSpacing: 160,
                    bottomSpacing: 20,
                    containerSelector: '#slider-container',
                    innerWrapperSelector: '.sidebar-inner',
                    scrollContainer: '.drawer-content',
                    minWidth: 1279,
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
