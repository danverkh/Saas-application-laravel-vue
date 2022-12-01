<template>
    <RankingTableFilters/>
    <SetFilterModal/>

    <div class="overflow-x-auto xl:overflow-visible">
        <table v-if="!error" class="table table-compact w-full">
            <thead>
            <tr>
                <th class="cursor-default !static">Keyword</th>
                <th><span class="tooltip cursor-default" data-tip="Search volume">Search Volume</span></th>
                <th class="text-right"><span class="tooltip cursor-default" data-tip="Cost per click">CPC</span></th>
                <th><span class="tooltip cursor-default" data-tip="Current rank">Rank</span></th>
                <th class="min-w-[160px]"><span class="tooltip cursor-default" data-tip="Website page URL">URL</span></th>
                <th class="text-right">Projected<br>clicks</th>
                <th class="text-right">Projected<br>traffic</th>
                <th class="text-right">Maximum<br>monthly cost</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <template v-if="!loading">
                <tr v-for="(item, index) in rankingItems.filteredItems" :key="`table-item-${index}`" :class="{selected: item.selected}">
                    <td class="whitespace-normal break-words min-w-[180px] font-medium white">
                        {{ withoutLastWord(item.keyword) }}
                        <span class="whitespace-nowrap">
                            {{ lastWord(item.keyword) }}
                            <svg @click="openPreviewRank(item.keyword)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 inline-block cursor-pointer ml-0.5 text-zinc-400 hover:text-primary transition duration-300">
                                <path d="M17.5 12a5.5 5.5 0 1 1 0 11a5.5 5.5 0 0 1 0-11zm.011 2l-.084.005l-.055.012l-.083.03l-.074.042l-.056.045l-2.513 2.512l-.057.07a.5.5 0 0 0 0 .568l.057.07l.07.057a.5.5 0 0 0 .568 0l.07-.057l1.645-1.646L17 21l.008.09a.5.5 0 0 0 .402.402l.09.008l.09-.008a.5.5 0 0 0 .402-.402L18 21l-.001-5.294l1.647 1.648l.07.057a.5.5 0 0 0 .695-.695l-.057-.07l-2.548-2.542l-.048-.032l-.067-.034l-.063-.021l-.054-.012A.5.5 0 0 0 17.51 14zM6.25 3h11.5a3.25 3.25 0 0 1 3.245 3.066L21 6.25l.001 5.773a6.47 6.47 0 0 0-1.5-.71L19.5 8h-15v9.75a1.75 1.75 0 0 0 1.606 1.744l.144.006h5.064a6.47 6.47 0 0 0 .709 1.501L6.25 21a3.25 3.25 0 0 1-3.245-3.066L3 17.75V6.25a3.25 3.25 0 0 1 3.066-3.245L6.25 3z" fill="currentColor" fill-rule="nonzero"/>
                            </svg>
                        </span>
                    </td>
                    <td class="text-right">{{ item.search_volume }}</td>
                    <td class="text-right">{{ item.cpc ? money(item.cpc) : '-' }}</td>
                    <td class="text-right">{{ item.current_rank }}</td>
                    <td class="whitespace-normal break-all" v-html="muteDomain(item.url)"></td>
                    <td class="text-right">{{ item.projected_clicks ? number(item.projected_clicks, 1) : '-' }}</td>
                    <td class="text-right">{{ item.projected_traffic ? number(item.projected_traffic, 1) : '-' }}</td>
                    <td class="text-right">{{ item.maximum_cost ? money(item.maximum_cost) : '-' }}</td>
                    <th class="text-right">
                        <button v-if="item.selected" @click="remove(item)" class="btn btn-sm w-16 text-[0.7rem] flex-nowrap rounded-[5px] border-none bg-red-600 hover:bg-red-700">
                            Remove
                        </button>

                        <button v-else @click="add(item)" class="btn btn-sm w-16 text-[0.7rem] flex-nowrap rounded-[5px] border-none bg-green-600 hover:bg-green-700">
                            Add
                            <svg class="h-4 w-4" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M96 220a12.2 12.2 0 0 1-8.5-3.5a12 12 0 0 1 0-17L159 128L87.5 56.5a12 12 0 0 1 17-17l80 80a12 12 0 0 1 0 17l-80 80A12.2 12.2 0 0 1 96 220Z"/>
                            </svg>
                        </button>
                    </th>
                </tr>

                <tr v-if="rankingItems.filteredItems.length === 0 && rankingItems.items.length > 0" class="no-hover">
                    <td colspan="9" class="text-center !py-12">
                        <div class="text-zinc-600 text-lg mb-5 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3">
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.25 17c0 .69-.559 1.25-1.25 1.25-.689 0-1.25-.56-1.25-1.25s.561-1.25 1.25-1.25c.691 0 1.25.56 1.25 1.25zm1.393-9.998c-.608-.616-1.515-.955-2.551-.955-2.18 0-3.59 1.55-3.59 3.95h2.011c0-1.486.829-2.013 1.538-2.013.634 0 1.307.421 1.364 1.226.062.847-.39 1.277-.962 1.821-1.412 1.343-1.438 1.993-1.432 3.468h2.005c-.013-.664.03-1.203.935-2.178.677-.73 1.519-1.638 1.536-3.022.011-.924-.284-1.719-.854-2.297z"/>
                            </svg>

                            <div>
                                No results found, try changing your filters
                            </div>
                        </div>
                    </td>
                </tr>

                <tr v-if="rankingItems.items.length === 0" class="no-hover">
                    <td colspan="9" class="text-center !py-12">
                        <div class="text-zinc-600 text-lg mb-5 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3">
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.25 17c0 .69-.559 1.25-1.25 1.25-.689 0-1.25-.56-1.25-1.25s.561-1.25 1.25-1.25c.691 0 1.25.56 1.25 1.25zm1.393-9.998c-.608-.616-1.515-.955-2.551-.955-2.18 0-3.59 1.55-3.59 3.95h2.011c0-1.486.829-2.013 1.538-2.013.634 0 1.307.421 1.364 1.226.062.847-.39 1.277-.962 1.821-1.412 1.343-1.438 1.993-1.432 3.468h2.005c-.013-.664.03-1.203.935-2.178.677-.73 1.519-1.638 1.536-3.022.011-.924-.284-1.719-.854-2.297z"/>
                            </svg>
                            <div>
                                There are no keywords for this domain for which AutoRanker can work.<br/>
                                We require existing rankings within the top 70 of search results to deliver results.<br/>
                                You can change your domain and market
                                <button @click="openModal('domain-switcher-modal')" class="text-primary hover:underline">here</button>
                                .
                            </div>
                        </div>
                    </td>
                </tr>
            </template>

            <tr v-else class="no-hover">
                <td colspan="9" class="text-center !py-12">
                    <spinner></spinner>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="error" class="text-center py-10">
            <div class="text-red-600 text-base text-center mb-5">{{ error }}</div>

            <button @click="fetch" class="btn gap-3 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-45">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                Try again
            </button>
        </div>
    </div>
</template>

<script>
import {useRankingItemsStore} from '@/stores/rankingItems';
import {usePreviewRankStore} from '@/stores/previewRank';
import {useCart} from '@/stores/cart';
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';
import Modal from "@/services/Modal";
import Url from "@/services/Url";
import RankingTableFilters from "@/pages/booking/ranking/RankingTableFilters.vue";
import SetFilterModal from "@/pages/booking/ranking/SetFilterModal.vue";

export default {
    name: "RankingsTable",

    components: {SetFilterModal, RankingTableFilters, Spinner},

    props: {
        market: String,
        domain: String,
    },

    data() {
        return {
            loading: true,
            error: null,
            rankingItems: useRankingItemsStore(),
        };
    },

    created() {
        this.fetch();

        useCart().market = this.market;
        useCart().domain = this.domain;
    },

    methods: {
        fetch() {
            this.loading = true;
            this.error   = null;

            const params = {
                market: this.market,
                domain: this.domain,
                assistant: Url.getQueryParam('assistant'),
            };

            axios.get(route('api.rankings'), {params})
                .then(resp => {
                    this.rankingItems.setItems(resp.data.rows);
                })
                .catch(error => {
                    console.error('Something went wrong', error);

                    if (error.response.status === 429) {
                        this.error = 'Too many search attempts, please try again in a minute';
                    } else {
                        this.error = 'Whoops, something went wrong... Please try again later';
                        console.error('Failed to fetch rankings', error);
                    }
                })
                .finally(() => this.loading = false);
        },

        remove(item) {
            useRankingItemsStore().remove(item);
        },

        add(item) {
            useRankingItemsStore().add(item);
        },

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

        withoutLastWord(string) {
            return string.substring(0, string.lastIndexOf(' '));
        },

        lastWord(string) {
            const words = string.split(' ');

            return words.length ? words.pop() : '';
        },

        openPreviewRank(keyword) {
            Modal.open('preview-rank');

            usePreviewRankStore().fetch(this.market, keyword, this.domain)
                .catch(error => {
                    if (error.message === 'canceled') {
                        console.info('Request was aborted');
                    } else {
                        console.error('Failed to fetch success preview', error);
                    }
                });
        },
    },
}
</script>
