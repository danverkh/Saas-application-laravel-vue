<template>
    <div class="bg-white rounded-lg shadow-lg py-5 px-6 w-80 pointer-events-none fixed z-50 hidden">
        <div class="flex flex-col gap-2">
            <div>
                <div class="font-semibold text-sm mb-0.5">
                    Search volume: {{ item.search_volume }}
                </div>
                <SearchVolumeChart :items="item.monthly_searches || []"/>
            </div>

            <div class="flex flex-nowrap">
                <div class="text-center">
                    <div class="font-semibold text-sm">Competition</div>
                    <Gauge :value="item.competition || 0" :max-value="100">
                        {{ item.competition || 0 }}%
                    </Gauge>
                </div>

                <div class="divider divider-horizontal"></div>

                <div class="text-center">
                    <div class="font-semibold text-sm">Cost Per Click</div>
                    <Gauge :value="item.cpc || 0" :max-value="maxCpc" flipped-colors>
                        <div class="text-sm">{{ number(item.cpc || 0, 1) }}€</div>
                    </Gauge>
                </div>
            </div>

            <div>
                <div class="font-semibold text-sm mb-0.5">Estimated Clicks</div>

                <EstimatedClicksChart :value="item.projected_clicks || 0"/>
            </div>
        </div>
    </div>
</template>

<script>
import SearchVolumeChart from "@/pages/booking/ranking/KeywordInfoPopover/SearchVolumeChart.vue";
import Gauge from "@/components/Gauge.vue";
import {useRankingItemsStore} from "@/stores/rankingItems";
import EstimatedClicksChart from "@/pages/booking/ranking/KeywordInfoPopover/EstimatedClicksChart.vue";

export default {
    name: "KeywordInfoPopover",

    components: {EstimatedClicksChart, Gauge, SearchVolumeChart},

    props: {
        item: {
            type: Object,
            required: true,
        },
    },

    computed: {
        maxCpc() {
            return useRankingItemsStore().max.cpc;
        },
    },
}
</script>
