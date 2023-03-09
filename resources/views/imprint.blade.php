@section('title', 'Imprint')
@section('description', 'AutoRanker.io provides User Signal and CTR SEO Marketing solutions for customers of all sizes.')

<x-main-layout>
    <div class="my-10 md:my-14">
        <x-page-title>
            Imprint
        </x-page-title>
    </div>

    <x-container>
        <div class="flex flex-col lg:flex-row justify-center gap-x-12 text-lg mb-12">
            <img src="/img/illustrations/imprint.svg" class="w-56 h-auto mx-auto lg:mr-2 mb-12 lg:mb-0"/>

            <div class="flex flex-col md:flex-row gap-x-12 mx-auto">
                <div class="space-y-2 max-w-xl">
                    <div class="text-2xl font-semibold">This service is offered by:</div>
                    <p>hPage Ltd.</p>
                    <p>Phoenix Business Centre</p>
                    <p>The Penthouse</p>
                    <p>Old Railway Track</p>
                    <p>Santa Venera SVR9022</p>
                    <p>Malta</p>
                </div>

                <div class="space-y-3 max-w-xl mt-8">
                    <p>
                        <span class="font-semibold">Managing Director:</span> Andreas Schroth
                    </p>

                    <p>Registered by the Registrar of Companies Malta</p>

                    <p>Registration Number: C 82500</p>

                    <p>
                        <span class="font-semibold">VATIN:</span> MT24558617
                    </p>

                    <p>
                        <span class="font-semibold mr-2">Our E-Mail:</span>
                        <x-link href="mailto:hello@autosuggest.io" active>hello@autosuggest.io</x-link>
                    </p>

                    <p>
                        <span class="font-semibold mr-2">Phone:</span>
                        <x-link href="tel:+442045711270" active>+44 20 4571127 - 0</x-link>
                    </p>
                </div>
            </div>
        </div>
    </x-container>
</x-main-layout>
