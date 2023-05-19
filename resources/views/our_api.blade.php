@section('title', 'Our API')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="my-10 md:my-14">
        <x-page-title>
            Our <span class="text-primary">API</span>
        </x-page-title>
    </div>

    <section class="max-w-screen-md mx-auto px-4 md:px-0 mb-16 space-y-12">
        <div class="py-6 mx-auto">
            <x-card class="px-3 py-4" title="Endpoints" titleSize="text-3xl">
                @foreach($endpoints as $endpoint)
                    <div>
                        <div
                            @class([
                                'flex font-mono rounded-lg border px-4 py-2 mb-3',
                                'bg-blue-100 border-blue-200' => $endpoint['type'] === 'GET',
                                'bg-yellow-100 border-yellow-200' => $endpoint['type'] === 'POST',
                            ])
                        >
                            <div
                                @class([
                                    'font-bold',
                                    'text-yellow-600' => $endpoint['type'] === 'POST',
                                    'text-blue-600' => $endpoint['type'] === 'GET',
                                ])
                            >{{ $endpoint['type'] }}</div>
                            <div class="divider divider-horizontal mx-4"></div>
                            <div>{{ $endpoint['url'] }}</div>
                        </div>
                        <div>{{ $endpoint['description'] }}</div>
                    </div>

                    <div class="divider my-2"></div>
                @endforeach

                <ul class="list-disc list-inside my-3">
                    <li>API available on request</li>
                    <li>actual API does not need to be implemented for now (so all the above is just static text)</li>
                </ul>

                <p>Some text that the API allows agencies etc to integrate AutoRanker in their workflows, send orders and cancellations directly from their CRM, build reporting dashboards for their clients etc.</p>
            </x-card>
        </div>
    </section>

    <x-search-domain></x-search-domain>
</x-main-layout>
