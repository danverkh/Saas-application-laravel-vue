<template>
    <div class="overflow-x-auto xl:overflow-visible">
        <table class="table table-compact w-full">
            <thead>
            <tr>
                <th class="cursor-default">Keyword</th>
                <th><span class="tooltip cursor-default" data-tip="Search volume">Search Volume</span></th>
                <th class="text-right"><span class="tooltip cursor-default" data-tip="Cost per click">CPC</span></th>
                <th><span class="tooltip cursor-default" data-tip="Current rank">Rank</span></th>
                <th class="hidden lg:table-cell"><span class="tooltip cursor-default" data-tip="Website page URL">URL</span></th>
                <th class="text-right">Projected<br>clicks</th>
                <th class="text-right">Projected<br>traffic</th>
                <th class="text-right">Maximum<br>monthly cost</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in selectedKeywords" :key="`table-item-${index}`">
                    <td class="whitespace-normal break-words min-w-[180px] font-medium white">{{ item.keyword }}</td>
                    <td class="text-right">{{ item.search_volume }}</td>
                    <td class="text-right">{{ item.cpc ? money(item.cpc) : '-' }}</td>
                    <td class="text-right">{{ item.current_rank }}</td>
                    <td class="whitespace-normal break-all hidden lg:table-cell" v-html="muteDomain(item.url)"></td>
                    <td class="text-right">{{ item.projected_clicks ? number(item.projected_clicks, 1) : '-' }}</td>
                    <td class="text-right">{{ item.projected_traffic ? number(item.projected_traffic, 1) : '-' }}</td>
                    <td class="text-right">{{ item.maximum_cost ? money(item.maximum_cost) : '-' }}</td>
                </tr>

                <tr v-if="selectedKeywords.length === 0" class="no-hover">
                    <td colspan="9" class="text-center !py-12">
                        <div class="text-zinc-600 text-lg mb-5 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3">
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.25 17c0 .69-.559 1.25-1.25 1.25-.689 0-1.25-.56-1.25-1.25s.561-1.25 1.25-1.25c.691 0 1.25.56 1.25 1.25zm1.393-9.998c-.608-.616-1.515-.955-2.551-.955-2.18 0-3.59 1.55-3.59 3.95h2.011c0-1.486.829-2.013 1.538-2.013.634 0 1.307.421 1.364 1.226.062.847-.39 1.277-.962 1.821-1.412 1.343-1.438 1.993-1.432 3.468h2.005c-.013-.664.03-1.203.935-2.178.677-.73 1.519-1.638 1.536-3.022.011-.924-.284-1.719-.854-2.297z"/>
                            </svg>
                            <div>
                                No keywords selected, please click
                                <button @click="openModal('domain-switcher-modal')" class="text-primary hover:underline">here</button>
                                .
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="my-3">
        <div class="flex flex-nowrap flex-row text-2xl">
            <div class="font-semibold pr-4">Total cost</div>
            <div class="font-bold pr-4">{{ money(0) }}</div>
        </div>
    </div>
</template>

<script>
import {useCart} from "../../stores/cart";

export default {
    name: "KeywordsTable",

    computed: {
        selectedKeywords() {
            return useCart().selectedItems;
        },
    },

    methods: {
        muteDomain(url) {
            try {
                const {origin, pathname} = new URL(url);

                return origin
                    ? `<span class="opacity-50">${origin}</span>${(pathname === '/' ? '' : pathname)}`
                    : url;
            } catch (error) {
                return url;
            }
        },
    },
}
</script>
