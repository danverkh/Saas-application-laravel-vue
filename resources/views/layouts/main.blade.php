<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;600;900&display=swap" rel="stylesheet">

        @routes

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div id="app">
            <!-- Header -->
            <header class="fixed top-0 w-full z-50 backdrop-blur-md bg-white-500/90 transition-all pt-4 pb-3 shadow-lg">
                <nav class="max-w-screen-xl px-6 sm:px-8 mx-auto grid grid-flow-col py-3 sm:py-4">
                    <div class="col-start-1 col-end-2 flex items-center">
                        <mobile-nav-button class="w-12 h-12 flex items-center mr-5 lg:hidden"></mobile-nav-button>

                        <a href="{{ route('homepage') }}">
                            <x-application-logo class="h-10 sm:h-12 w-auto"></x-application-logo>
                        </a>
                    </div>

                    <ul class="hidden lg:flex col-start-4 col-end-8 text-black-500  items-center">
                        <x-nav-link href="#" :active="true">How it works</x-nav-link>
                        <x-nav-link href="#" :active="false">Success stories</x-nav-link>
                        <x-nav-link href="#" :active="false">About us</x-nav-link>
                        <x-nav-link href="#" :active="false">Pricing</x-nav-link>
                    </ul>
                    <div class="col-start-10 col-end-12 font-medium flex justify-end items-center">
                        <a href="/" class="text-black-600 mx-4 sm:mx-6 capitalize tracking-wide font-medium hover:text-primary transition-all">Login</a>
                        <a href="/" class="font-medium tracking-wide py-2 px-5 sm:px-6 border border-primary-hover text-white-500 bg-primary outline-none rounded-l-full rounded-r-full hover:bg-primary-hover hover:text-white-500 transition-all duration-500 hover:shadow-primary">
                            Get a demo
                        </a>
                    </div>
                </nav>
            </header>

            <div class="drawer">
                <input id="mobile-menu" type="checkbox" class="drawer-toggle"/>
                <div class="drawer-content pt-[100px] sm:pt-[108px] bg-zinc-100/20">
                    @yield('hero')

                    <!-- Content -->
                    <div class="flex w-full">
                        <div class="h-full w-full py-12">
                            {{ $slot }}
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-zinc-200 py-12 md:py-20 mt-20">
                        <div class="max-w-screen-xl w-full mx-auto px-6 sm:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-4">
                            <div class="flex flex-col items-start">
                                <p class="text-black-600 mb-4 font-medium text-2xl">Sitemap</p>
                                <ul class="text-black-500">
                                    <li class="my-2 hover:text-primary cursor-pointer transition-all">
                                        <x-link href="#" :with-color="false">Home</x-link>
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
                                        <x-link href="#" :with-color="false">Imprint</x-link>
                                    </li>
                                    <li class="my-2 hover:text-primary cursor-pointer transition-all">
                                        <x-link href="#" :with-color="false">Data Privacy</x-link>
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
                </div>

                <!-- Mobile navigation -->
                <div class="drawer-side">
                    <label for="mobile-menu" class="drawer-overlay"></label>
                    <ul class="menu overflow-y-auto w-80 bg-base-100 text-base-content mt-24 p-6 pt-10 pr-7">
                        <li><x-mobile-nav-link href="#" :active="true">How it works</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link href="#" :active="false">Success stories</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link href="#" :active="false">About us</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link href="#" :active="false">Pricing</x-mobile-nav-link></li>
                    </ul>
                </div>
            </div>
        </div>

        @stack('script')
    </body>
</html>
