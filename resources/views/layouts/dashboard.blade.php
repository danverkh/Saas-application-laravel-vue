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
            <assistant-modal></assistant-modal>
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
                            <div class="max-w-screen-xl mx-auto px-6 xl:px-2 flex justify-end items-center py-1 sm:py-2">
                                <div class="text-sm text-zinc-900 hover:text-accent">
                                    <a href="{{ route('dashboard.campaigns') }}" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="fill-current md:w-4 md:h-4 mr-1">
                                            <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88a9.947 9.947 0 0 1 12.28 0C16.43 19.18 14.03 20 12 20z"/>
                                        </svg>
                                        <span class="hidden md:inline">{{ auth()->user()->email }}</span>
                                    </a>
                                </div>

                                <div class="text-zinc-300 mx-3">|</div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="link no-underline hover:underline flex items-center tracking-wide transition-colors text-primary/80 hover:text-primary">
                                        <svg class="hidden sm:block w-4 h-4 mr-1" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.413-.587Q3 19.825 3 19V5q0-.825.587-1.413Q4.175 3 5 3h7v2H5v14h7v2Zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5Z"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="transition-all shadow-lg">
                            <div class="backdrop-blur-[10px] bg-white-500/90 py-2">
                                <nav class="max-w-screen-xl mx-auto px-2 sm:px-6 xl:px-2 grid grid-flow-col py-3 sm:py-4">
                                    <div class="col-start-1 col-end-2 flex items-center">
                                        <mobile-nav-button class="w-12 h-12 flex items-center mr-1 sm:mr-5 lg:hidden"></mobile-nav-button>

                                        <a href="{{ route('homepage') }}">
                                            <x-application-logo class="h-10 sm:h-12 w-auto"></x-application-logo>
                                        </a>
                                    </div>

                                    <ul class="hidden lg:flex col-start-4 col-end-8 text-black-500  items-center">
                                        <x-nav-link :href="route('dashboard.campaigns')" :active="request()->routeIs('dashboard.campaigns.keyword')">My Campaigns</x-nav-link>
                                        <x-nav-link :href="route('dashboard.account')" :active="request()->routeIs('dashboard.account.*')">My Account</x-nav-link>
                                        <x-nav-link :href="route('dashboard.support')" :active="request()->routeIs('dashboard.support*')">Support</x-nav-link>
                                    </ul>

                                    <div class="col-start-10 col-end-12 font-medium flex justify-end items-center">
                                        <div onclick="document.getElementById('assistant-modal').checked = true" class="cursor-pointer select-none text-sm sm:text-base font-medium tracking-wide py-2 px-3 sm:px-6 border border-primary-hover text-white-500 bg-primary outline-none rounded-l-full rounded-r-full hover:bg-primary-hover hover:text-white-500 transition-all duration-500 hover:shadow-primary">
                                            <span class="hidden sm:inline-block">Create a Campaign</span>
                                            <span class="inline-block sm:hidden">Campaign</span>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    {{ $slot }}

                    <!-- Footer -->
                    @include('layouts.parts.footer')
                </div>

                <!-- Mobile navigation -->
                <div class="drawer-side mt-[129px] sm:mt-[145px] md:mt-[137px]" style="display: none">
                    <label for="mobile-menu" class="drawer-overlay"></label>
                    <ul class="menu overflow-y-auto w-80 divide-y bg-base-100 text-base-content p-6 pt-8 pr-7" style="box-shadow: inset 0 4px 18px -9px rgba(0,0,0,0.4)">
                        <li><x-mobile-nav-link :href="route('dashboard.campaigns')" :active="request()->routeIs('dashboard.campaigns.keyword')">My Campaign</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link :href="route('dashboard.account')" :active="request()->routeIs('dashboard.account.*')">My Account</x-mobile-nav-link></li>
                        <li><x-mobile-nav-link :href="route('dashboard.support')" :active="request()->routeIs('dashboard.support')">Support</x-mobile-nav-link></li>
                    </ul>
                </div>
            </div>
        </div>

        @stack('script')

        @if(session()->has('error'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    window.GlobalNotification.handle({error: '{{ session('error') }}'});
                });
            </script>
        @endif
    </body>
</html>
