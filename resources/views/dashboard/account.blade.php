@section('title', 'My account')
@section('description', '')

<x-dashboard-layout>
    <x-container class="mb-8">
        <div id="slider-container" class="flex-col flex flex-nowrap gap-6 xl:flex-row">
            <div id="sidebar" class="sidebar w-full z-10">
                <div class="sidebar__inner flex flex-col gap-6 md:block md:columns-2 md:space-y-6 xl:flex xl:columns-1 xl:space-y-0">
                    <x-card class="border-t-4 border-primary overflow-visible" bodyClass="px-5 py-1">
                        <div class="divide-y">
                            <div class="py-2">
                                <a href="{{ route('dashboard.account.billing_address') }}" class="btn btn-ghost btn-block text-base normal-case break-all {{ request()->routeIs('dashboard.account.billing_address') ? 'text-primary' : '' }}">
                                    Billing Address
                                </a>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>

            <div id="content" class="space-y-10">
                <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
                    <div class="p-8">
                        @include("dashboard.account.{$page}")
                    </div>
                </div>
            </div>
        </div>
    </x-container>

    @push('script')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = new StickySidebar('#sidebar', {
                    topSpacing: 160,
                    bottomSpacing: 20,
                    containerSelector: '#slider-container',
                    innerWrapperSelector: '.sidebar-inner',
                    scrollContainer: '.drawer-content',
                    minWidth: 1279,
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
