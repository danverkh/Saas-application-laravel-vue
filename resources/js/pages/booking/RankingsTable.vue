<template>
    <div class="overflow-x-auto xl:overflow-visible">
        <table v-if="!error" class="table table-compact w-full">
            <thead>
            <tr>
                <th>
                    <input type="checkbox"
                           id="check-all-items"
                           @click="rankingItems.toggleAll($event.target.checked)"
                           class="checkbox checkbox-xs bg-white rounded text-primary"
                           :disabled="loading || !rankingItems.items.length"/>
                </th>
                <th class="cursor-default">Keyword</th>
                <th><span class="tooltip cursor-default" data-tip="Search volume">Search</span></th>
                <th class="text-right"><span class="tooltip cursor-default" data-tip="Cost per click">CPC</span></th>
                <th><span class="tooltip cursor-default" data-tip="Current rank">Rank</span></th>
                <th><span class="tooltip cursor-default" data-tip="Website page URL">URL</span></th>
                <th class="text-right">Projected<br>clicks</th>
                <th class="text-right">Projected<br>traffic</th>
                <th class="text-right">Maximum<br> cost</th>
            </tr>
            </thead>
            <tbody>
                <template v-if="!loading">
                    <tr v-for="(item, index) in rankingItems.items" :key="`table-item-${index}`" :class="{selected: item.selected}">
                        <th>
                            <input type="checkbox" v-model="item.selected" @click="update" class="checkbox checkbox-xs bg-white rounded text-primary"/>
                        </th>
                        <td class="whitespace-normal break-words min-w-[180px] font-medium">{{ item.keyword }}</td>
                        <td class="text-right">{{ item.search_volume }}</td>
                        <td class="text-right">{{ item.cpc ? money(item.cpc) : '-' }}</td>
                        <td class="text-right">{{ item.current_rank }}</td>
                        <td class="whitespace-normal break-all" v-html="muteDomain(item.url)"></td>
                        <td class="text-right">{{ item.projected_clicks ? number(item.projected_clicks, 1) : '-' }}</td>
                        <td class="text-right">{{ item.projected_traffic ? number(item.projected_traffic, 1) : '-' }}</td>
                        <td class="text-right">{{ item.maximum_cost ? money(item.maximum_cost) : '-' }}</td>
                    </tr>

                    <tr v-if="rankingItems.items.length === 0" class="no-hover">
                        <td colspan="9" class="text-center !py-12">
                            <div class="text-zinc-600 text-lg mb-5 flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3">
                                    <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1.25 17c0 .69-.559 1.25-1.25 1.25-.689 0-1.25-.56-1.25-1.25s.561-1.25 1.25-1.25c.691 0 1.25.56 1.25 1.25zm1.393-9.998c-.608-.616-1.515-.955-2.551-.955-2.18 0-3.59 1.55-3.59 3.95h2.011c0-1.486.829-2.013 1.538-2.013.634 0 1.307.421 1.364 1.226.062.847-.39 1.277-.962 1.821-1.412 1.343-1.438 1.993-1.432 3.468h2.005c-.013-.664.03-1.203.935-2.178.677-.73 1.519-1.638 1.536-3.022.011-.924-.284-1.719-.854-2.297z"/>
                                </svg>
                                <div>
                                    There are no keywords for this domain for which AutoRanker can work.<br />
                                    We require existing rankings within the top 70 of search results to deliver results.<br />
                                    You can change your domain and market <button @click="openModal('domain-switcher-modal')" class="text-primary hover:underline">here</button>.
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Try again
            </button>
        </div>
    </div>
</template>

<script>
import {useRankingItemsStore} from '../../stores/rankingItems';
import axios from 'axios';
import Spinner from '../../components/Spinner.vue';

export default {
    name: "RankingsTable",

    components: {Spinner},

    props: {
        market: String,
        query: String,
    },

    data() {
        return {
            loading: true,
            error: null,
            rankingItems: useRankingItemsStore(),
        };
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;
            this.error = null;

            axios.get(route('api.rankings'), {params: {market: this.market, query: this.query}})
                .then(resp => {
                    this.rankingItems.setItems(resp.data.rows);
                })
                .catch(error => {
                    console.error('Something wen wrong', error);

                    if (error.response.status === 429) {
                        this.error = 'Too many search attempts, please try again in a minute';
                    } else {
                        this.error = 'Whoops, something went wrong... Please try again later';
                        console.error('Failed to fetch rankings', error);
                    }
                })
                .finally(() => this.loading = false);
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

        update() {
           setTimeout(() => this.rankingItems.update(), 1);
        },
    },
}
</script>
