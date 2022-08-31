<x-main-layout>
    <div class="max-w-screen-xl px-6 sm:px-8 mx-auto">
        <div class="flex flex-nowrap gap-8">
            <div class="basis-2/3 flex flex-col gap-6">
                <x-card class="border-t-4 border-primary gap-0">
                    <div class="flex flex-nowrap gap-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-20 h-20 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>

                        <div class="xl:pr-20">
                            <h4 class="text-2xl font-medium mb-2 text-zinc-800">Please select keywords</h4>
                            <p class="text-sm italic text-zinc-400">From the list below, select keywords which you think a potential customer of your services would be searching.</p>
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

                    <div class="overflow-x-auto">
                        <table class="table table-compact table-zebra w-full">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary"/></th>
                                <th>Keyword</th>
                                <th>Ranking</th>
                                <th>Clicks</th>
                                <th>Searches</th>
                                <th>Competition</th>
                                <th>CPC</th>
                                <th>URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary"/></th>
                                <th>1</th>
                                <td>Cy Ganderton</td>
                                <td>Quality Control Specialist</td>
                                <td>Littel, Schaden and Vandervort</td>
                                <td>Canada</td>
                                <td>12/16/2020</td>
                                <td>Blue</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <div class="basis-1/3 flex flex-col gap-6">
                <a href="#" class="flex flex-nowrap items-center px-6 py-5 text-lg font-semibold text-right text-white tracking-wider uppercase transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50 hover:shadow-green-500/50">
                    <div class="flex-1">Confirm keywords <br class="hidden xl:block"> and proceed</div>

                    <span class="divider divider-horizontal"></span>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd" d="M3.75 12a.75.75 0 01.75-.75h13.19l-5.47-5.47a.75.75 0 011.06-1.06l6.75 6.75a.75.75 0 010 1.06l-6.75 6.75a.75.75 0 11-1.06-1.06l5.47-5.47H4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                    </svg>
                </a>

                <x-card class="border-t-4 border-zinc-300">
                    <div class="text-lg inline-block">
                        Domain: <span class="font-semibold">example.com</span>
                        <button class="inline-block text-base ml-2 hover:text-primary hover:underline">(change)</button>
                    </div>
                </x-card>

                <x-card class="border-t-4 border-zinc-300 gap-0">
                    <h4 class="-mt-2 font-medium text-xl">Forecasted Results</h4>

                    <div class="divider divider-vertical my-0"></div>

                    <div>
                        <div class="text-md">Target audience size</div>
                        <div class="text-2xl font-semibold">17,000+</div>
                    </div>

                    <div class="divider divider-vertical my-0"></div>

                    <div class="tabs w-full flex-nowrap -mt-3 mb-3">
                        <a class="tab tab-lg tab-active">1-day</a>
                        <a class="tab tab-lg">7-day</a>
                        <a class="tab tab-lg">30-day</a>
                    </div>

                    <div class="mb-4">
                        <div class="text-md">1-day spend</div>
                        <div class="text-2xl font-semibold">€36.00 - €840.00</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-md">1-day impressions</div>
                        <div class="text-2xl font-semibold">14,000 - 5,700</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-md">CTR</div>
                        <div class="text-2xl font-semibold">1.0% - 1.6%</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-md">
                            30-day clicks
                            <div class="badge bg-violet-600 border-none ml-2">Key Result</div>
                        </div>
                        <div class="text-2xl font-semibold">20 - 84</div>
                    </div>

                    <div class="text-sm -mb-2">
                        Forecasted results aer directional estimates and do not guarantee performance.
                        <a href="#" class="text-primary hover:underline whitespace-nowrap">Learn more</a>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-main-layout>
