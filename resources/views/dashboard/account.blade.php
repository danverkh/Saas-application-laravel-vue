@section('title', 'My account')
@section('description', '')

<x-dashboard-layout>
    <x-container class="mb-8">
        <div id="sidebar-container" class="flex flex-nowrap flex-col md:flex-row gap-6">
            <div id="sidebar" class="sidebar z-10 md:w-1/3">
                <div class="sidebar__inner flex flex-col gap-6 md:block md:space-y-6 md:flex md:space-y-0">
                    <x-card class="border-t-4 border-primary overflow-visible" bodyClass="px-5 py-1">
                        <div class="divide-y">
                            <div class="py-2">
                                <a href="{{ route('dashboard.account.details') }}" class="btn btn-ghost btn-block text-base normal-case break-all {{ request()->routeIs('dashboard.account.details') ? 'text-primary' : '' }}">
                                    Details
                                </a>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('dashboard.account.billing_address') }}" class="btn btn-ghost btn-block text-base normal-case break-all {{ request()->routeIs('dashboard.account.billing_address') ? 'text-primary' : '' }}">
                                    Billing Address
                                </a>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('dashboard.account.password_change') }}" class="btn btn-ghost btn-block text-base normal-case break-all {{ request()->routeIs('dashboard.account.password_change') ? 'text-primary' : '' }}">
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>

            <div id="content" class="w-full">
                @include("dashboard.account.{$page}")
            </div>
        </div>
    </x-container>

    @push('script')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = new StickySidebar('#sidebar', {
                    topSpacing: 160,
                    bottomSpacing: 20,
                    containerSelector: '#sidebar-container',
                    innerWrapperSelector: '.sidebar-inner',
                    scrollContainer: '.drawer-content',
                    minWidth: 1279,
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
