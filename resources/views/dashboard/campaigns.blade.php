@section('title', 'Dashboard')
@section('description', '')

<x-dashboard-layout>
    <cancel-keyword-confirmation></cancel-keyword-confirmation>
    <reactivate-keyword-confirmation></reactivate-keyword-confirmation>

    <x-container class="mb-8">
        <div id="sidebar-container" class="flex-col flex flex-nowrap gap-6 xl:flex-row">
            <div id="sidebar" class="sidebar w-full z-10">
                <div class="sidebar__inner flex flex-col gap-6 md:block md:space-y-6 xl:flex xl:space-y-0">
                    <x-card class="border-t-4 border-primary overflow-visible md:w-1/2 xl:w-full" bodyClass="px-5 py-1">
                        <div class="divide-y">
                            <campaigns-sidebar :domains='@json($domains)'></campaigns-sidebar>
                        </div>
                    </x-card>
                </div>
            </div>

            <div id="content" class="space-y-10">
                <campaign-keyword></campaign-keyword>
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

            window.addEventListener('resize', setSidebarDropdown);
            setSidebarDropdown();

            function setSidebarDropdown() {
                document.querySelectorAll('#sidebar .dropdown')
                    .forEach(function (elem) {
                        if (window.innerWidth <= 768) {
                            elem.classList.add('dropdown-end');
                            elem.classList.remove('dropdown-right');
                        } else {
                            elem.classList.remove('dropdown-end');
                            elem.classList.add('dropdown-right');
                        }
                    });
            }
        </script>
    @endpush
</x-dashboard-layout>
