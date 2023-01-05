@section('title', 'Success stories')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="my-14">
        <x-page-title>
            Success <span class="text-primary">stories</span>
        </x-page-title>
    </div>

    <section class="max-w-screen-xl mx-auto mb-16 space-y-8">
        @foreach($items as $item)
            <x-card class="border-t-4 border-zinc-300">
                <div class="grid grid-cols-3">
                    <div class="col-span-1 font-medium">
                        <div class="text-xl font-bold text-primary">Client in</div>
                        <div class="text-3xl text-zinc-900 my-1">{{ $item->client_industry }}</div>
                        <div class="text-xl font-bold text-zinc-400">industry</div>

                        <div class="mt-4 text-lg text-zinc-700">From {{ $item->client_city }}</div>

                        <div class="mt-4 text-lg text-zinc-700">
                            Campaign active since:
                            <span class="font-bold">{{ $item->campaign_active_since->format('d.m.Y') }}</span>
                        </div>
                    </div>

                    <div class="col-span-2">stats
                        chart
                    </div>
                </div>
            </x-card>
        @endforeach
    </section>

    <div class="mb-16">
        <x-search-domain></x-search-domain>
    </div>
</x-main-layout>
