@section('title', 'Dashboard')
@section('description', 'Here you can view your details')

<x-dashboard-layout>
    <x-container>
        <div class="space-y-10">
            @foreach($orders->groupBy('domain') as $domain => $orders)
                @foreach($orders->pluck('keywords')->flatten() as $keyword)
                <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
                    <div class="flex justify-between w-full bg-zinc-100 border-b border-b-zinc-200/50 py-8 px-10">
                        <div class="flex space-x-6">
                            <div>
                                <div class="text-zinc-500">Domain</div>
                                <div class="text-zinc-800 text-3xl font-medium">{{ $domain }}</div>
                            </div>

                            <div class="divider divider-horizontal"></div>

                            <div>
                                <div class="text-zinc-500">Keyword</div>
                                <div class="text-3xl font-medium text-primary">{{ $keyword->keyword }}</div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <span class="tooltip" data-tip="Cancel keyword">
                                <svg class="w-7 h-7 cursor-pointer text-zinc-500 hover:text-primary transition-colors duration-200" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M7 21q-.825 0-1.412-.587Q5 19.825 5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413Q17.825 21 17 21Zm2-4h2V8H9Zm4 0h2V8h-2Z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-10 p-10 pt-7">
                        <div class="w-full lg:w-1/2">
                            <div class="text-xl font-medium text-zinc-700 text-center mb-2">Ranking improvement</div>
                            <ranking-improvement-chart></ranking-improvement-chart>
                        </div>

                        <div class="w-full lg:w-1/2">
                            <div class="text-xl font-medium text-zinc-700 text-center mb-2">Estimated clicks & traffic</div>

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
