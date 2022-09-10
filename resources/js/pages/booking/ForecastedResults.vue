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

    <div class="mt-4 mb-2">
        <input type="range" min="0.8" max="4" v-model="conversionRate" step="0.1" class="range range-xs range-primary" style="--range-shdw: 351 72% 52%; --bc: 225 5% 0%"/>
        <div class="text-md">Leads</div>
        <div class="text-2xl font-semibold">{{ number(leads, 0) }}</div>
    </div>

    <div class="divider divider-vertical my-0"></div>

    <div class="tabs w-full flex-nowrap -mt-3 mb-3">
        <a class="tab tab-lg" :class="{'tab-active': days === 1}" @click="days = 1">1-day</a>
        <a class="tab tab-lg" :class="{'tab-active': days === 30}" @click="days = 30">30-days</a>
    </div>

    <div class="mb-4">
        <div class="text-md">{{ daysLabel }} spend</div>
        <div class="text-2xl font-semibold">{{ money(spend.min) }} - {{ money(spend.max) }}</div>
    </div>

    <div class="mb-4">
        <div class="text-md">{{ daysLabel }} impressions</div>
        <div class="text-2xl font-semibold">{{ number(impressions.min, 0) }} - {{ number(impressions.max, 0) }}</div>
    </div>

    <div class="mb-4">
        <div class="text-md">CTR</div>
        <div class="text-2xl font-semibold">{{ number(ctr.min, 1) }}% - {{ number(ctr.max, 1) }}%</div>
    </div>

    <div class="mb-4">
        <div class="text-md">
            {{ daysLabel }} clicks
            <div class="badge bg-violet-600 border-none ml-2">Key Result</div>
        </div>
        <div class="text-2xl font-semibold">{{ number(clicks.min, 0) }} - {{number(clicks.max, 0)}}</div>
    </div>
</template>

<script>
import {useRankingItemsStore} from '../../stores/rankingItems';
import generator from 'random-seed';
import {round, ceil} from 'lodash';

export default {
    name: "ForecastedResults",

    data() {
        return {
            days: 1,
            conversionRate: 1.8,
            successPercentage: 80,
            rankingItems: useRankingItemsStore(),
        };
    },

    computed: {
        daysLabel() {
            return `${this.days}-day` + (this.days > 1 ? 's' : '');
        },

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

        spend() {
            return {
                min: this.days * this.maximumCostSum * 0.5,
                max: this.days * this.maximumCostSum,
            };
        },

        impressions() {
            return {
                min: this.days * this.audienceSize * 0.5,
                max: this.days * this.audienceSize,
            };
        },

        ctr() {
            if (this.audienceSize === 0) {
                return {min: 0, max: 0};
            }

            const seed = this.audienceSize;
            const variation = generator(seed).floatBetween(-2, 2);

            return {
                min: 11.2 + variation,
                max: 18.8 + variation,
            };
        },

        leads() {
            const clicks = (this.clicks.min + this.clicks.max) / 2;

            return ceil(clicks * Number(this.conversionRate));
        },

        clicks() {
            return {
                min: this.impressions.min * round(this.ctr.min, 1),
                max: this.impressions.max * round(this.ctr.max, 1),
            };
        },
    },
}
</script>
