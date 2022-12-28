<template>
    <tr :class="{selected: item.selected}">
        <td class="whitespace-normal break-words min-w-[180px] font-medium white">
            {{ withoutLastWord(item.keyword) }}
            <span class="whitespace-nowrap">
                {{ lastWord(item.keyword) }}
                <svg @click="openPreviewRank(item.keyword)" class="w-4 h-4 inline-block cursor-pointer mx-0.5 text-zinc-400 hover:text-primary transition duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.5 12a5.5 5.5 0 1 1 0 11a5.5 5.5 0 0 1 0-11zm.011 2l-.084.005l-.055.012l-.083.03l-.074.042l-.056.045l-2.513 2.512l-.057.07a.5.5 0 0 0 0 .568l.057.07l.07.057a.5.5 0 0 0 .568 0l.07-.057l1.645-1.646L17 21l.008.09a.5.5 0 0 0 .402.402l.09.008l.09-.008a.5.5 0 0 0 .402-.402L18 21l-.001-5.294l1.647 1.648l.07.057a.5.5 0 0 0 .695-.695l-.057-.07l-2.548-2.542l-.048-.032l-.067-.034l-.063-.021l-.054-.012A.5.5 0 0 0 17.51 14zM6.25 3h11.5a3.25 3.25 0 0 1 3.245 3.066L21 6.25l.001 5.773a6.47 6.47 0 0 0-1.5-.71L19.5 8h-15v9.75a1.75 1.75 0 0 0 1.606 1.744l.144.006h5.064a6.47 6.47 0 0 0 .709 1.501L6.25 21a3.25 3.25 0 0 1-3.245-3.066L3 17.75V6.25a3.25 3.25 0 0 1 3.066-3.245L6.25 3z" fill="currentColor" fill-rule="nonzero"/>
                </svg>

                <span class="hidden lg:inline-block"
                      @mouseenter="openKeywordInfoPopover(item)"
                      @mousemove="moveKeywordInfoPopover"
                      @mouseleave="hideKeywordInfoPopover">

                    <svg class="w-4 h-4 inline-block ml-0.5 text-zinc-400 hover:text-primary transition duration-300" width="32" height="32" viewBox="0 0 256 256">
                        <path fill="currentColor" d="M216 36h-76V24a12 12 0 0 0-24 0v12H40a20.1 20.1 0 0 0-20 20v120a20.1 20.1 0 0 0 20 20h31l-16.4 20.5a12.1 12.1 0 0 0 1.9 16.9A12.4 12.4 0 0 0 64 236a12 12 0 0 0 9.4-4.5l28.4-35.5h52.4l28.4 35.5a12 12 0 0 0 9.4 4.5a12.4 12.4 0 0 0 7.5-2.6a12.1 12.1 0 0 0 1.9-16.9L185 196h31a20.1 20.1 0 0 0 20-20V56a20.1 20.1 0 0 0-20-20Zm-4 136H44V60h168Zm-108-52v24a12 12 0 0 1-24 0v-24a12 12 0 0 1 24 0Zm24-28a12 12 0 0 1 12 12v40a12 12 0 0 1-24 0v-40a12 12 0 0 1 12-12Zm24 52V88a12 12 0 0 1 24 0v56a12 12 0 0 1-24 0Z"/>
                    </svg>
                </span>
            </span>
        </td>
        <td class="text-right">
            <SearchVolumeBar :value="item.search_volume" class="min-w-[55px]"/>
        </td>
        <td class="text-right">
            <CpcBar :value="item.cpc" class="min-w-[55px]"/>
        </td>
        <td class="text-right">
            <RelevanceBar :item="item"/>
        </td>
        <td class="text-right">{{ item.current_rank || '-' }}</td>
        <td class="whitespace-normal break-all !text-xs" v-html="muteDomain(item.url || '-')"></td>
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
</template>

<script>
import {useRankingItemsStore} from "@/stores/rankingItems";
import SearchVolumeBar from "@/pages/booking/ranking/SearchVolumeBar.vue";
import CpcBar from "@/pages/booking/ranking/CpcBar.vue";
import RelevanceBar from "@/pages/booking/ranking/RelevanceBar.vue";
import HelpersMixin from "@/pages/booking/ranking/mixins/HelpersMixin";
import PopoverMixin from "@/pages/booking/ranking/mixins/KeywordInfoPopoverMixin";
import Modal from "@/services/Modal";
import {usePreviewRankStore} from "@/stores/previewRank";
import {useCart} from "@/stores/cart";

export default {
    name: "RankingTableRow",

    mixins: [HelpersMixin, PopoverMixin],

    components: {RelevanceBar, CpcBar, SearchVolumeBar},

    props: {
        item: {
            type: Object,
            required: true,
        },
    },

    methods: {
        remove(item) {
            useRankingItemsStore().remove(item);
        },

        add(item) {
            useRankingItemsStore().add(item);
        },

        openPreviewRank(keyword) {
            Modal.open('preview-rank');

            usePreviewRankStore().fetch(useCart().market, keyword, useCart().domain)
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
