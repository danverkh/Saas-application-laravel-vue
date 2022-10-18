<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/>

        <title>{{ config('app.name') }} | @yield('title')</title>
        <meta name="description" content="@yield('description')"/>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;600;900&display=swap" rel="stylesheet">

        @routes

        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        @stack('style')
    </head>
    <body>
        <div id="app"
             @if(auth()->check())
                 data-auth='@json(auth()->user()->only(['id', 'name', 'email']))'
             @endif
        >

            <!-- Global -->
            <full-screen-spinner></full-screen-spinner>
            <domain-switcher-modal></domain-switcher-modal>
            <global-notifications></global-notifications>

            @env('local')
            <x-breakpoints></x-breakpoints>
            @endenv

            <div class="drawer overflow-y-auto">
                <input id="mobile-menu" type="checkbox" class="drawer-toggle"/>
                <div class="drawer-content bg-zinc-100/20">
                    <!-- Header -->
                    <header class="sticky top-0 w-full z-40">
                        <div class="bg-zinc-50 border-b border-b-zinc-200">
                            <div class="max-w-screen-xl mx-auto px-6 xl:px-2 flex justify-between py-1 sm:py-2">
                                <div></div>
                                <login-form></login-form>
                            </div>
                        </div>

                        <div class="backdrop-blur-[10px] bg-white-500/90 transition-all py-2 shadow-lg">
                            <nav class="max-w-screen-xl mx-auto px-6 xl:px-2 grid grid-flow-col py-3 sm:py-4">
                                <div class="col-start-1 col-end-2 flex items-center">
                                    <mobile-nav-button class="w-12 h-12 flex items-center mr-1 sm:mr-5 lg:hidden"></mobile-nav-button>

                                    <a href="{{ route('homepage') }}">
                                        <x-application-logo class="h-10 sm:h-12 w-auto"></x-application-logo>
                                    </a>
                                </div>

                                <ul class="hidden lg:flex col-start-4 col-end-8 text-black-500  items-center">
                                    <x-nav-link :href="route('how_it_works')" :active="request()->routeIs('how_it_works')">How it works</x-nav-link>
                                    <x-nav-link :href="route('success_stories')" :active="request()->routeIs('success_stories')">Success stories</x-nav-link>
                                    <x-nav-link :href="route('about_us')" :active="request()->routeIs('about_us')">About us</x-nav-link>
                                    <x-nav-link href="#" :active="false">Pricing</x-nav-link>
                                </ul>
                                <div class="col-start-10 col-end-12 font-medium flex justify-end items-center">
                                    @auth
                                        <div class="hidden sm:block mr-5 text-zinc-900">{{ auth()->user()->email }}</div>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex flex-nowrap items-center font-medium tracking-wide py-2 px-5 sm:px-6 border border-primary-hover text-white-500 bg-primary outline-none rounded-l-full rounded-r-full hover:bg-primary-hover hover:text-white-500 transition-all duration-500 hover:shadow-primary">
                                                <svg class="hidden sm:block w-5 h-5 mr-1.5" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.413-.587Q3 19.825 3 19V5q0-.825.587-1.413Q4.175 3 5 3h7v2H5v14h7v2Zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5Z"/></svg>
                                                Logout
                                            </button>
                                        </form>
                                    @else
                                        <a href="/" class="text-sm sm:text-base font-medium tracking-wide py-2 px-3 sm:px-6 border border-primary-hover text-white-500 bg-primary outline-none rounded-l-full rounded-r-full hover:bg-primary-hover hover:text-white-500 transition-all duration-500 hover:shadow-primary">
                                            <span class="hidden sm:inline-block">Get a demo</span>
                                            <span class="inline-block sm:hidden">Demo</span>
                                        </a>
                                    @endauth
                                </div>
                            </nav>
                        </div>
                    </header>

                    <!-- Content -->
                    {{ $slot }}

                    <!-- Footer -->
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
                <div class="drawer-side" style="display: none">
                    <label for="mobile-menu" class="drawer-overlay mt-[100px] sm:mt-[108px]"></label>
                    <ul class="menu overflow-y-auto w-80 divide-y bg-base-100 text-base-content mt-[100px] sm:mt-[108px] p-6 pt-8 pr-7"
                        style="box-shadow: inset 0 4px 18px -9px rgba(0,0,0,0.4)">
                        <li><x-mobile-nav-link :href="route('how_it_works')" :active="request()->routeIs('how_it_works')">How it works</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link :href="route('success_stories')" :active="request()->routeIs('success_stories')">Success stories</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link :href="route('about_us')" :active="request()->routeIs('about_us')">About us</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link href="#" :active="false">Pricing</x-mobile-nav-link></li>
                    </ul>
                </div>
            </div>
        </div>

        @stack('script')
    </body>
</html>
