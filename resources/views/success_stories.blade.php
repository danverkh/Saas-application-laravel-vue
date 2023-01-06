@section('title', 'Success stories')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="my-14">
        <x-page-title>
            Success <span class="text-primary">stories</span>
        </x-page-title>
    </div>

    <section class="max-w-screen-xl mx-auto mb-16 space-y-12">
        @foreach($items as $item)
            <success-story :item='@json($item)'></success-story>
        @endforeach

        <show-more-success-stories-btn></show-more-success-stories-btn>
    </section>

    <div class="mb-16">
        <x-search-domain></x-search-domain>
    </div>
</x-main-layout>
