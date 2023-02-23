<div class="bg-zinc-200 py-12 md:py-20">
    <div class="max-w-screen-xl w-full mx-auto px-6 xl:px-2 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-4">
        <div class="flex flex-col items-start">
            <p class="text-black-600 mb-4 font-medium text-2xl">Sitemap</p>
            <ul class="text-black-500">
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link :href="route('homepage')" :with-color="false">Home</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">Reviews</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">FAQ</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">Pricing</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">Contact</x-link>
                </li>
            </ul>
        </div>
        <div class="flex flex-col">
            <ul class="text-black-500 mt-11">
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="{{ route('imprint') }}" :with-color="false">Imprint</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="{{ route('data_privacy') }}" :with-color="false">Data Privacy</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">Keyword Finder</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">Customer Area</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="#" :with-color="false">For Agencies</x-link>
                </li>
                <li class="my-2 hover:text-primary cursor-pointer transition-all">
                    <x-link href="{{ route('our-api') }}" :with-color="false">Our API</x-link>
                </li>
            </ul>
        </div>
        <div class="flex flex-col">
            <p class="text-black-600 mb-4 font-medium text-2xl">Contact</p>
            <ul class="text-black-500">
                <li class="my-2">E-Mail: <x-link href="mailto:hello@autosuggest.io" active>hello@autosuggest.io</x-link></li>
                <li class="my-2">Phone: <x-link href="tel:+442045711270" active>+44 20 4571127 - 0</x-link></li>
                <li class="my-2">Meeting: <x-link href="#" active>Schedule here</x-link></li>
            </ul>
        </div>
        <div class="flex flex-col">
            <p class="text-black-600 mb-4 font-medium text-2xl">About Us</p>
            <ul class="text-black-500">
                <li class="my-2">
                    AutoSuggest: organic autocomplete marketing.
                </li>
                <li class="my-2">
                    <img src="/img/payment-methods-international.png" class="h-14 mt-6">
                </li>
            </ul>
        </div>
    </div>
</div>
