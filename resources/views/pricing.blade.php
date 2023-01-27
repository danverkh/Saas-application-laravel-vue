@section('title', 'Pricing')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="mt-14">
        <x-page-title>
            Pricing
        </x-page-title>
    </div>

    <section class="max-w-screen-xl mx-auto mb-16 space-y-12">
        <div class="py-10 mx-auto">

            <div class="text-center">
                <a href="{{ route('success_stories') }}" class="inline-flex items-center pl-8 pr-5 py-4 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    See examples of clients
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 ml-3 transition-transform group-hover:translate-x-0.5"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <div class="mb-12">
        <x-search-domain></x-search-domain>
    </div>
</x-main-layout>
