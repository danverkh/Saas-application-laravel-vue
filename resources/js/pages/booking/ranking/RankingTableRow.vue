<template>
    <tr :class="{selected: item.selected, 'text-zinc-400': item.requestPending}">
        <td class="whitespace-normal break-words min-w-[180px] font-medium white">
            <div>
                {{ withoutLastWord(item.keyword) }}
                <span class="whitespace-nowrap">
                    {{ lastWord(item.keyword) }}
                    <svg v-if="isValid(item)" @click="openPreviewRank(item.keyword)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 inline-block cursor-pointer mx-0.5 text-zinc-400 hover:text-primary transition duration-300" viewBox="0 0 24 24">
                      <path d="M17.5 12a5.5 5.5 0 1 1 0 11 5.5 5.5 0 0 1 0-11zm0 2h-.2l-.1.1-2.6 2.5v.1a.5.5 0 0 0 0 .6l.1.1a.5.5 0 0 0 .6 0l1.7-1.7V21a.5.5 0 0 0 .4.5h.1a.5.5 0 0 0 .5-.4v-5.4l1.6 1.7h.1a.5.5 0 0 0 .7-.7L17.8 14h-.1l-.1-.1zM6.2 3h11.6A3.3 3.3 0 0 1 21 6v6a6.5 6.5 0 0 0-1.5-.7V8h-15v9.8a1.8 1.8 0 0 0 1.6 1.7h5.2A6.5 6.5 0 0 0 12 21H6.2A3.3 3.3 0 0 1 3 18V6.2A3.3 3.3 0 0 1 6 3h.3z"/>
                    </svg>

                    <span v-if="isValid(item)" class="hidden lg:inline-block"
                          @mouseenter="openKeywordInfoPopover(item)"
                          @mousemove="moveKeywordInfoPopover"
                          @mouseleave="hideKeywordInfoPopover">

                        <svg class="w-4 h-4 inline-block ml-0.5 text-zinc-400 hover:text-primary transition duration-300" width="32" height="32" viewBox="0 0 256 256">
                            <path fill="currentColor" d="M216 36h-76V24a12 12 0 0 0-24 0v12H40a20.1 20.1 0 0 0-20 20v120a20.1 20.1 0 0 0 20 20h31l-16.4 20.5a12.1 12.1 0 0 0 1.9 16.9A12.4 12.4 0 0 0 64 236a12 12 0 0 0 9.4-4.5l28.4-35.5h52.4l28.4 35.5a12 12 0 0 0 9.4 4.5a12.4 12.4 0 0 0 7.5-2.6a12.1 12.1 0 0 0 1.9-16.9L185 196h31a20.1 20.1 0 0 0 20-20V56a20.1 20.1 0 0 0-20-20Zm-4 136H44V60h168Zm-108-52v24a12 12 0 0 1-24 0v-24a12 12 0 0 1 24 0Zm24-28a12 12 0 0 1 12 12v40a12 12 0 0 1-24 0v-40a12 12 0 0 1 12-12Zm24 52V88a12 12 0 0 1 24 0v56a12 12 0 0 1-24 0Z"/>
                        </svg>
                    </span>
                </span>
            </div>

            <div v-if="item.requestPending" class="flex items-center my-1">
                <Spinner color="#3C84F5" :size="12" :border-width="2" class="mx-1"></Spinner>
                <span class="text-blue-500 text-xs">getting evaluated</span>
            </div>

            <div v-if="item.status === 'not_possible' || item.status === 'failed'" class="text-red-400 text-2xs">
                this keyword is not possible as of now
            </div>
        </td>
        <td class="text-right">
            <SearchVolumeBar :value="item.search_volume" class="min-w-[55px]" :class="{'opacity-30': !item.search_volume}"/>
        </td>
        <td class="text-right">
            <CpcBar :value="item.cpc" class="min-w-[55px]" :class="{'opacity-30': !item.cpc}"/>
        </td>
        <td class="text-right">
            <RelevanceBar :item="item" :class="{'opacity-30': !item.relevance}"/>
        </td>
        <td class="text-right">{{ item.current_rank || '-' }}</td>
        <td class="whitespace-normal break-all !text-xs" v-html="muteDomain(item.url || '-')"></td>
        <td class="text-right">{{ item.projected_clicks ? number(item.projected_clicks, 1) : '-' }}</td>
        <td class="text-right">{{ item.projected_traffic ? number(item.projected_traffic, 1) : '-' }}</td>
        <td class="text-right">{{ item.maximum_cost ? money(item.maximum_cost) : '-' }}</td>
        <th class="text-right">
            <button v-if="item.selected" @click="remove(item)" class="btn btn-sm w-16 text-[0.7rem] flex-nowrap rounded-[5px] border-none bg-red-600 hover:bg-red-700" :disabled="!isValid(item)">
                Remove
            </button>

            <button v-else @click="add(item)" class="btn btn-sm w-16 text-[0.7rem] flex-nowrap rounded-[5px] border-none bg-green-600 hover:bg-green-700" :disabled="!isValid(item)">
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
import Spinner from "@/components/Spinner.vue";

export default {
    name: "RankingTableRow",

    mixins: [HelpersMixin, PopoverMixin],

    components: {Spinner, RelevanceBar, CpcBar, SearchVolumeBar},

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

        isValid(item) {
            return !item.status || item.status === 'possible';
        },
    },
}
</script>
