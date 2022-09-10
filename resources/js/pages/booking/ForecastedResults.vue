<template>
    <div>
        <div class="text-md">Target audience size</div>
        <div class="text-2xl font-semibold">{{ audienceSize }}+</div>
    </div>

    <div class="w-full bg-zinc-600 h-3 my-3 rounded-xl overflow-hidden">
        <div class="h-3 transition-all duration-1000 ease-out"
             :class="{
                'bg-red-500': maximumCostSum < 200,
                'bg-yellow-500': maximumCostSum >= 200 && maximumCostSum < 600,
                'bg-green-500': maximumCostSum >= 600,
              }"
             :style="{width: `${sliderPercentage}%`}"></div>
    </div>

    <div class="divider divider-vertical my-0"></div>

    <div class="tabs w-full flex-nowrap -mt-3 mb-3">
        <a class="tab tab-lg" :class="{'tab-active': day === 1}" @click="day = 1">1-day</a>
        <a class="tab tab-lg" :class="{'tab-active': day === 7}" @click="day = 7">7-day</a>
        <a class="tab tab-lg" :class="{'tab-active': day === 30}" @click="day = 30">30-day</a>
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
</template>

<script>
import {useRankingItemsStore} from '../../stores/rankingItems';

export default {
    name: "ForecastedResults",

    data() {
        return {
            successPercentage: 80,
            day: 1,
            rankingItems: useRankingItemsStore(),
        };
    },

    computed: {
        selectedItems() {
            return this.rankingItems.selectedItems;
        },

        audienceSize() {
            return this.selectedItems.reduce((sum, item) => sum + item.search_volume, 0);
        },

        maximumCostSum() {
            return this.selectedItems.reduce((sum, item) => sum + item.maximum_cost, 0);
        },

        sliderPercentage() {
            const percentage = this.maximumCostSum / 1000 * 100;

            return Math.min(percentage, 100);
        },
    },
}
</script>
