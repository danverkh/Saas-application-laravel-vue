@section('title', 'Dashboard')
@section('description', 'Here you can view your details')

<x-dashboard-layout>
    <x-container>
        @foreach($orders->pluck('keywords')->flatten() as $keyword)
        <x-card class="px-2 lg:px-8 py-1 lg:py-4 border border-zinc-100">
            <h2 class="text-zinc-900 text-3xl font-medium text-center">{{ $keyword->keyword }}</h2>

            <div class="w-8 h-1 bg-primary mt-2 mb-4 mx-auto"></div>

            <div class="flex gap-5">
                <div class="w-1/2">
                    <div class="text-xl font-medium text-zinc-700 text-center mb-4">Ranking improvement</div>
                </div>

                <div class="w-1/2">
                    <div class="text-xl font-medium text-zinc-700 text-center mb-4">Estimated clicks & traffic</div>

                    <campaign-progress-prediction-chart
                        value="{{ $keyword->keyword }}"
                        :impressions=""
                        :spend=""
                    ></campaign-progress-prediction-chart>
                </div>
            </div>
        </x-card>
        @endforeach
    </x-container>
</x-dashboard-layout>
