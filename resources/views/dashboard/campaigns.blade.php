@section('title', 'Dashboard')
@section('description', '')

<x-dashboard-layout>
    <cancel-keyword-confirmation></cancel-keyword-confirmation>

    <x-container class="mb-8">
        <div id="sidebar-container" class="flex-col flex flex-nowrap gap-6 xl:flex-row">
            <div id="sidebar" class="sidebar w-full z-10">
                <div class="sidebar__inner flex flex-col gap-6 md:block md:space-y-6 xl:flex xl:space-y-0">
                    <x-card class="border-t-4 border-primary overflow-visible md:w-1/2 xl:w-full" bodyClass="px-5 py-1">
                        <div class="divide-y">
                            @foreach($domains as $domain => $keywords)
                                <div class="dropdown w-full py-2">
                                    <label tabindex="0" class="btn btn-ghost btn-block text-base normal-case break-all {{ (collect($keywords)->contains('keyword', $keyword->keyword)) ? 'text-primary' : '' }}">
                                        {{ $domain }}
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 divide-y rounded-box w-52 ml-3 border border-zinc-200/80">
                                        @foreach(collect($keywords)->sortBy('keyword') as $domainKeyword)
                                            <li class="px-2 py-2">
                                                <a href="{{ route('dashboard.campaigns.keyword', $domainKeyword->id) }}"
                                                    class="py-2 {{ ($domainKeyword->id === $keyword->id) ? 'text-primary' : '' }}">
                                                    {{ $domainKeyword->keyword }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                </div>
            </div>

            <div id="content" class="space-y-10">
                <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
                    <div class="flex justify-between w-full bg-zinc-300 py-3 md:py-4 px-5 md:px-7">
                        <div class="flex flex-col space-y-1 md:space-y-0 md:flex-row md:space-x-4">
                            <div>
                                <div class="text-zinc-600 text-xs md:text-sm">Domain</div>
                                <div class="text-zinc-800 text-xl md:text-2xl font-medium">{{ $keyword->domain }}</div>
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
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 mt-2">
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

                    <div class="border-b border-zinc-200 grid grid-cols-2 md:block">
                        <keyword-stats></keyword-stats>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-6 md:gap-10 p-6 md:p-10 pt-7">
                        <div class="w-full lg:w-1/2">
                            <div class="text-md md:text-xl font-medium text-zinc-700 text-center mb-2">Ranking improvement</div>
                            <keyword-ranking-improvement-chart></keyword-ranking-improvement-chart>
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
            </div>
        </div>
    </x-container>

    @push('script')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = new StickySidebar('#sidebar', {
                    topSpacing: 160,
                    bottomSpacing: 20,
                    containerSelector: '#sidebar-container',
                    innerWrapperSelector: '.sidebar-inner',
                    scrollContainer: '.drawer-content',
                    minWidth: 1279,
                });
            });

            window.addEventListener('resize', setSidebarDropdown);
            setSidebarDropdown();

            function setSidebarDropdown() {
                document.querySelectorAll('#sidebar .dropdown')
                    .forEach(function (elem) {
                        if (window.innerWidth <= 768) {
                            elem.classList.add('dropdown-end');
                            elem.classList.remove('dropdown-right');
                        } else {
                            elem.classList.remove('dropdown-end');
                            elem.classList.add('dropdown-right');
                        }
                    });
            }
        </script>
    @endpush
</x-dashboard-layout>
