<template>
    <RankingTableFilters v-if="!error"/>
    <SetFilterModal/>
    <KeywordInfoPopover/>

    <div class="overflow-x-auto">
        <table v-if="!error" ref="mainTable" class="table table-compact w-full">
            <thead>
            <tr class="top-[137px] z-10 border-b border-b-zinc-200">
                <th class="cursor-default !static">Keyword</th>
                <TableHead field="search_volume" sortable>Search<br>Volume</TableHead>
                <TableHead field="cpc" sortable class="text-right">
                    <span class="tooltip tooltip-bottom z-10" data-tip="Cost per click">CPC</span>
                </TableHead>
                <TableHead field="relevance" sortable class="text-right">
                    <span class="tooltip tooltip-bottom z-10" data-tip="Relevance">Rel</span>
                </TableHead>
                <TableHead field="current_rank" sortable>
                    <span class="tooltip tooltip-bottom z-10" data-tip="Current rank">Rank</span>
                </TableHead>
                <TableHead field="url" sortable class="min-w-[130px]">
                    <span class="tooltip tooltip-bottom z-10" data-tip="Website page URL">URL</span>
                </TableHead>
                <TableHead field="projected_clicks" sortable class="text-right">Projected<br>clicks</TableHead>
                <TableHead field="projected_traffic" sortable class="text-right">Projected<br>traffic</TableHead>
                <TableHead field="maximum_cost" sortable class="text-right">Maximum<br>monthly cost</TableHead>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <template v-if="!loading">
                <RankingTableRow
                    v-for="item in rankingItems.filteredItems"
                    :key="`table-item-${item.keyword}`"
                    :item="item"
                />

                <tr v-if="rankingItems.filteredItems.length === 0 && rankingItems.items.length > 0" class="no-hover">
                    <td colspan="9" class="text-center !py-12">
                        <div class="text-zinc-600 text-lg mb-5 flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3" viewBox="0 0 24 24">
                                <path d="M12 2a10.01 10.01 0 0 1 0 20 10.01 10.01 0 0 1 0-20zm0-2a12 12 0 1 0 0 24 12 12 0 0 0 0-24zm1.25 17a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0zm1.4-10a3.53 3.53 0 0 0-2.56-.95C9.91 6.05 8.5 7.6 8.5 10h2.01c0-1.49.83-2.02 1.54-2.02.64 0 1.3.42 1.37 1.23.06.85-.4 1.28-.97 1.82-1.4 1.34-1.43 2-1.43 3.47h2c0-.66.04-1.2.94-2.18.68-.73 1.52-1.64 1.54-3.02a3.13 3.13 0 0 0-.86-2.3z"/>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-12 h-12 text-zinc-200 block mb-3" viewBox="0 0 24 24">
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10S2 17.514 2 12 6.486 2 12 2zm0-2C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm1.25 17a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0zm1.393-9.998c-.608-.616-1.515-.955-2.551-.955-2.18 0-3.59 1.55-3.59 3.95h2.011c0-1.486.829-2.013 1.538-2.013.634 0 1.307.421 1.364 1.226.062.847-.39 1.277-.962 1.821-1.412 1.343-1.438 1.993-1.432 3.468h2.005c-.013-.664.03-1.203.935-2.178.677-.73 1.519-1.638 1.536-3.022.011-.924-.284-1.719-.854-2.297z"/>
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
                    <Spinner></Spinner>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="error" class="text-center py-10">
            <div class="text-red-600 text-base text-center mb-5">{{ error }}</div>

            <button @click="fetch" class="btn gap-3 group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-45" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.02 9.35h5v0M2.98 19.65v-5m0 0h5m-5 0 3.18 3.18a8.25 8.25 0 0 0 13.8-3.7M4.04 9.86a8.25 8.25 0 0 1 13.8-3.7l3.19 3.19m0-5v5"/>
                </svg>
                Try again
            </button>
        </div>
    </div>
</template>

<script>
import {useRankingItemsStore} from '@/stores/rankingItems';
import {useCart} from '@/stores/cart';
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';
import Url from "@/services/Url";
import RankingTableFilters from "@/pages/booking/ranking/RankingTableFilters.vue";
import SetFilterModal from "@/pages/booking/ranking/SetFilterModal.vue";
import KeywordInfoPopover from "@/pages/booking/ranking/KeywordInfoPopover.vue";
import FixedTableHeaderMixin from "@/pages/booking/ranking/mixins/FixedTableHeaderMixin";
import RankingTableRow from "@/pages/booking/ranking/RankingTableRow.vue";
import TableHead from "@/pages/booking/ranking/TableHead.vue";

export default {
    name: "RankingsTable",

    components: {TableHead, RankingTableRow, KeywordInfoPopover, SetFilterModal, RankingTableFilters, Spinner},

    mixins: [FixedTableHeaderMixin],

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

    mounted() {
        document.querySelector('.drawer-content')
            .addEventListener('scroll', () => {
                if (window.outerWidth >= 1280) {
                    this.fixedTableHeader();
                }
            });
    },

    methods: {
        fetch() {
            this.loading = true;
            this.error   = null;

            const params = {
                market: this.market,
                domain: this.domain,
                assistant: Url.getQueryParam('assistant'),
                user_id: this.$auth.check ? this.$auth.user.id : null,
            };

            axios.get(route('api.rankings'), {params})
                .then(resp => {
                    this.rankingItems.setItems(resp.data.rows, resp.data.purchased_keywords);
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
    },
}
</script>
