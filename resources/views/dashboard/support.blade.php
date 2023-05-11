@section('title', 'Support')
@section('description', '')

<x-dashboard-layout>
    <x-container class="mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-0 gap-y-8 lg:gap-8">
            <div class="col-span-2">
                <x-card class="px-0 lg:px-8 border border-zinc-100 mb-6">
                    <h2 class="font-medium text-center mt-2">
                        <div class="text-3xl text-zinc-700 mb-2">Welcome to our support page!</div>
                        <div class="text-xl text-zinc-400">We're here to help you with any questions or issues you may have.</div>
                    </h2>
                    <div class="w-16 h-1 bg-primary my-2.5 mx-auto"></div>
                </x-card>

                <x-card class="px-0 lg:px-8 border border-zinc-100">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        <a href="{{ route('dashboard.support.faq', 'faq_performance') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'faq_performance')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">FAQ Performance</a>
                        <a href="{{ route('dashboard.support.faq', 'faq_tracking') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'faq_tracking')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">FAQ Tracking</a>
                        <a href="{{ route('dashboard.support.faq', 'faq_billing') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'faq_billing')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">FAQ Billing</a>
                        <a href="{{ route('dashboard.support.faq', 'getting_started_with_your_first_campaign') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'getting_started_with_your_first_campaign')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">Getting started with your first campaign</a>
                        <a href="{{ route('dashboard.support.faq', 'faq_api') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'faq_api')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">FAQ API</a>
                        <a href="{{ route('dashboard.support.faq', 'faq_agencies') }}" class="btn btn-ghost btn-block normal-case hover:bg-primary leading-5 h-16 {{ (url()->current() === route('dashboard.support.faq', 'faq_agencies')) ? 'bg-primary text-white' : 'bg-zinc-200 text-zinc-700 hover:text-zinc-100' }}">FAQ Agencies</a>
                    </div>

                    @if(isset($faqs))
                    <div class="mt-8">
                        @foreach ($faqs as $faq)
                            <div class="collapse rounded-xl collapse-arrow mb-2">
                                <input type="checkbox" class="peer" />
                                <div class="collapse-title text-xl font-medium bg-zinc-200/20 peer-checked:bg-zinc-200/50">
                                    {{ $faq->question }}
                                </div>
                                <div class="collapse-content bg-zinc-200/20 peer-checked:bg-zinc-200/50">
                                    <div class="p-3 bg-white rounded-xl">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </x-card>
            </div>

            <div class="col-span-1">
                <x-card class="px-0 py-3 lg:px-5 border border-zinc-100" bodyClass="py-6 flex flex-nowrap justify-between flex-col sm:flex-row lg:flex-col">
                    <div class="flex gap-7 place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 20 20" class="text-primary shrink-0">
                            <path fill="currentColor" fill-rule="evenodd" d="m7.172 11.334l2.83 1.935l2.728-1.882l6.115 6.033c-.161.052-.333.08-.512.08H1.667c-.22 0-.43-.043-.623-.12l6.128-6.046ZM20 6.376v9.457c0 .247-.054.481-.15.692l-5.994-5.914L20 6.376ZM0 6.429l6.042 4.132l-5.936 5.858A1.663 1.663 0 0 1 0 15.833V6.43ZM18.333 2.5c.92 0 1.667.746 1.667 1.667v.586L9.998 11.648L0 4.81v-.643C0 3.247.746 2.5 1.667 2.5h16.666Z"/>
                        </svg>
                        <div>
                            <div class="text-xl text-zinc-700">Send as an E-Mail:</div>
                            <a href="mailto:support@autoranker.io" class="underline text-lg font-medium text-primary">support@autoranker.io</a>
                        </div>
                    </div>

                    <div class="divider my-3"></div>

                    <div class="flex gap-7 place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" class="text-primary shrink-0">
                            <g fill="none">
                                <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/>
                                <path fill="currentColor" d="M6.857 2.445C8 3.278 8.89 4.415 9.65 5.503l.442.644l.417.615a1.504 1.504 0 0 1-.256 1.986l-1.951 1.449a.48.48 0 0 0-.142.616c.442.803 1.228 1.999 2.128 2.899c.901.9 2.153 1.738 3.012 2.23a.483.483 0 0 0 .644-.162l1.27-1.933a1.503 1.503 0 0 1 2.056-.332l.663.459c1.239.86 2.57 1.837 3.588 3.14a1.47 1.47 0 0 1 .189 1.484c-.837 1.953-2.955 3.616-5.158 3.535l-.3-.017l-.233-.02l-.258-.03l-.281-.038l-.305-.05a11.66 11.66 0 0 1-.16-.03l-.336-.072a12.399 12.399 0 0 1-.176-.04l-.366-.094l-.385-.11l-.402-.13c-1.846-.626-4.189-1.856-6.593-4.26c-2.403-2.403-3.633-4.746-4.259-6.592l-.13-.402l-.11-.385l-.094-.366l-.078-.346a11.79 11.79 0 0 1-.063-.326l-.05-.305l-.04-.281l-.029-.258l-.02-.233l-.016-.3c-.081-2.196 1.6-4.329 3.544-5.162a1.47 1.47 0 0 1 1.445.159Zm8.135 3.595l.116.013a3.5 3.5 0 0 1 2.858 2.96a1 1 0 0 1-1.958.393l-.023-.115a1.5 1.5 0 0 0-1.07-1.233l-.155-.035a1 1 0 0 1 .232-1.983ZM15 3a6 6 0 0 1 6 6a1 1 0 0 1-1.993.117L19 9a3.998 3.998 0 0 0-3.738-3.991L15 5a1 1 0 1 1 0-2Z"/>
                            </g>
                        </svg>
                        <div>
                            <div class="text-xl text-zinc-700">Book a call:</div>
                            <a href="#" class="underline text-lg font-medium text-primary">click here</a>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </x-container>
</x-dashboard-layout>
