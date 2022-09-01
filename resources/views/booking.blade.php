<x-main-layout>
    <div class="max-w-screen-xl px-6 sm:px-8 mx-auto">
        <div class="flex flex-nowrap gap-8">
            <div class="w-2/3 flex flex-col gap-6">
                <x-card class="border-t-4 border-primary gap-0">
                    <div class="flex flex-nowrap gap-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-20 h-20 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        <div class="xl:pr-20">
                            <h4 class="text-2xl font-medium mb-2 text-zinc-800">Please select keywords</h4>
                            <p class="text-sm text-zinc-400">
                                From the list below, select keywords which you think a potential customer
                                <br class="hidden xl:block">
                                of your services would be searching.
                            </p>
                        </div>
                    </div>

                    <div class="divider divider-vertical my-0"></div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary float-left mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        There are no costs for you until you receive traffic for these keywords.
                    </div>
                </x-card>

                <x-card class="border-t-4 border-primary">
                    <x-slot:title>Interesting rankings</x-slot:title>

                    <rankings-table market="{{ $market }}" query="{{ $query }}"></rankings-table>
                </x-card>
            </div>

            <div class="basis-1/3 flex flex-col gap-6">
                <a href="#" class="group flex flex-nowrap items-center px-6 py-5 text-lg font-semibold text-right text-white tracking-wider uppercase transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50 hover:shadow-green-500/50">
                    <div class="flex-1">Confirm keywords <br class="hidden xl:block"> and proceed</div>

                    <span class="divider divider-horizontal ml-4 mr-2"></span>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 transition-transform group-hover:translate-x-0.5">
                        <path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/>
                    </svg>
                </a>

                <x-card class="border-t-4 border-zinc-300">
                    <query-switcher market="{{ $market }}" query="{{ $query }}" :is-domain="{{ $isDomain ? 'true' : 'false' }}"></query-switcher>
                </x-card>

                <x-card class="border-t-4 border-zinc-300 gap-0">
                    <h4 class="-mt-2 font-medium text-xl">Forecasted Results</h4>

                    <div class="divider divider-vertical my-0"></div>

                    <forecasted-results></forecasted-results>

                    <div class="text-sm -mb-6 -mx-8 pt-4 pb-5 px-8 bg-zinc-50 text-zinc-500">
                        Forecasted results are directional estimates and do not guarantee performance.
                        <a href="#" class="text-primary hover:underline whitespace-nowrap">Learn more</a>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-main-layout>
<script>
    import DomainSwitcher from "../js/pages/booking/QuerySwitcher";
    export default {
        components: {DomainSwitcher}
    }
</script>
