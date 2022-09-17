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
        <a class="tab tab-lg" :class="{'tab-active': days === 1}" @click="days = 1">1-day</a>
        <a class="tab tab-lg" :class="{'tab-active': days === 30}" @click="days = 30">30-days</a>
    </div>

    <div class="mb-4">
        <div class="text-md">{{ daysLabel }} spend</div>

        <div v-if="days === 1" class="no-hover">
            <div class="text-2xl font-semibold">{{ number(spend.min) }} € - {{ number(spend.max) }} €</div>
        </div>
        <div v-else>
            <div class="text-2xl font-semibold">{{ number(spend.min, 0) }} € - {{ number(spend.max, 0) }} €</div>
        </div>
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
        </div>
        <div class="text-2xl font-semibold">{{ number(clicks.min, 0) }} - {{number(clicks.max, 0)}}</div>
    </div>

    <div class="mb-4">
        <div class="text-md">
            {{ daysLabel }} leads
            <div class="badge bg-violet-600 border-none ml-2">Key Result</div>
        </div>
        <div class="text-2xl font-semibold">{{ number(leads.min, 0) }} - {{number(leads.max, 0)}}</div>
    </div>

</template>

<script>
import {useRankingItemsStore} from '@/stores/rankingItems';
import generator from 'random-seed';
import {round, ceil} from 'lodash';

export default {
    name: "ForecastedResults",

    data() {
        return {
            days: 1,
            conversionRate: 0.018,
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
                min: this.days * this.maximumCostSum * 0.5 / 30,
                max: this.days * this.maximumCostSum / 30,
            };
        },

        impressions() {
            if (this.audienceSize > 0 && this.audienceSize < 120) {
                return {
                    min: this.days * this.audienceSize * 0.5 / 30,
                    max: (this.days * this.audienceSize / 30) + 1,
                };
            }

            return {
                min: this.days * this.audienceSize * 0.5 / 30,
                max: this.days * this.audienceSize / 30,
            };
        },

        ctr() {
            if (this.audienceSize === 0) {
                return {min: 0, max: 0};
            }

            const seed = this.audienceSize;
            const maximumAbsoluteVariation = 6 - Math.log10(this.audienceSize); /* larger sample sizes have lower variance */
            const baselineDelta = generator(seed).floatBetween(0, maximumAbsoluteVariation);

            return {
                min: 12.2 - baselineDelta,
                max: 16.8 + baselineDelta,
            };
        },

        clicks() {
            if (this.audienceSize > 0 && this.audienceSize < 120) {
                return {
                    min: this.impressions.min * round(this.ctr.min, 1) / 100,
                    max: (this.impressions.max * round(this.ctr.max, 1) / 100) + 1,
                };
            }

            return {
                min: this.impressions.min * round(this.ctr.min, 1) / 100,
                max: this.impressions.max * round(this.ctr.max, 1) / 100,
            };
        },

        leads() {
            return {
                min: this.clicks.min * Number(this.conversionRate) * 0.8,
                max: ceil(this.clicks.max * Number(this.conversionRate) * 1.2),
            };
        },
    },
}
</script>
