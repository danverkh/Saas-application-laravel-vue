@section('title', 'Dashboard')
@section('description', 'Here you can view your details')

<x-dashboard-layout>
    <cancel-keyword-confirmation></cancel-keyword-confirmation>

    <x-container class="mb-8">
        <div class="space-y-10">
            @foreach($orders->groupBy('domain') as $domain => $orders)
                @foreach($orders->pluck('keywords')->flatten() as $keyword)
                <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
                    <div class="flex justify-between w-full bg-zinc-100 border-b border-b-zinc-200/50 py-4 md:py-6 px-6 md:px-10">
                        <div class="flex flex-col space-y-1 md:space-y-0 md:flex-row md:space-x-6">
                            <div>
                                <div class="text-zinc-500 text-sm md:text-base">Domain</div>
                                <div class="text-zinc-800 text-2xl md:text-3xl font-medium">{{ $domain }}</div>
                            </div>

                            <div class="divider divider-vertical md:divider-horizontal"></div>

                            <div>
                                <div class="text-zinc-500 text-sm md:text-base">Keyword</div>
                                <div class="text-2xl md:text-3xl font-medium text-primary">{{ $keyword->keyword }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="tooltip" data-tip="Cancel keyword" onclick="document.getElementById('cancel-keyword-confirmation').checked = true">
                                <svg class="w-6 h-6 md:w-7 md:h-7 cursor-pointer text-zinc-500 hover:text-red-600 transition-colors duration-200" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587Q5 19.825 5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413Q17.825 21 17 21Zm2-4h2V8H9Zm4 0h2V8h-2Z"/>
                                </svg>
                            </span>
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
    </x-container>
</x-dashboard-layout>
