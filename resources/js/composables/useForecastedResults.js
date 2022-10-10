import {computed, ref} from 'vue';
import generator from "random-seed";
import round from "lodash/round";
import ceil from "lodash/ceil";
import {useRankingItemsStore} from "@/stores/rankingItems";

export function useForecastedResults(days) {
    const rankingItems = useRankingItemsStore();

    const conversionRate = ref(0.018);

    const daysLabel = computed(() => {
        return `${days.value}-day` + (days.value > 1 ? 's' : '');
    });

    const selectedItems = computed(() => {
        return rankingItems.selectedItems;
    });

    const audienceSize = computed(() => {
        return selectedItems.value.reduce((sum, item) => sum + item.search_volume, 0);
    });

    const maximumCostSum = computed(() => {
        return selectedItems.value.reduce((sum, item) => sum + item.maximum_cost, 0);
    });

    const sliderPercentage = computed(() => {
        const percentage = maximumCostSum.value / 1000 * 100;

        return Math.min(percentage, 100);
    });

    const spend = computed(() => {
        return {
            min: days.value * maximumCostSum.value * 0.5 / 30,
            max: days.value * maximumCostSum.value / 30,
        };
    });

    const impressions = computed(() => {
        if (audienceSize.value > 0 && audienceSize.value < 120) {
            return {
                min: days.value * audienceSize.value * 0.5 / 30,
                max: (days.value * audienceSize.value / 30) + 1,
            };
        }

        return {
            min: days.value * audienceSize.value * 0.5 / 30,
            max: days.value * audienceSize.value / 30,
        };
    });

    const ctr = computed(() => {
        if (audienceSize.value === 0) {
            return {min: 0, max: 0};
        }

        const seed = audienceSize.value;
        const maximumAbsoluteVariation = 6 - Math.log10(audienceSize.value); /* larger sample sizes have lower variance */
        const baselineDelta = generator(seed).floatBetween(0, maximumAbsoluteVariation);

        return {
            min: 12.2 - baselineDelta,
            max: 16.8 + baselineDelta,
        };
    });

    const clicks = computed(() => {
        if (audienceSize.value > 0 && audienceSize.value < 120) {
            return {
                min: impressions.value.min * round(ctr.value.min, 1) / 100,
                max: (impressions.value.max * round(ctr.value.max, 1) / 100) + 1,
            };
        }

        return {
            min: impressions.value.min * round(ctr.value.min, 1) / 100,
            max: impressions.value.max * round(ctr.value.max, 1) / 100,
        };
    });

    const leads = computed(() => {
        return {
            min: clicks.value.min * Number(conversionRate.value) * 0.8,
            max: ceil(clicks.value.max * Number(conversionRate.value) * 1.2),
        };
    });

    return {
        daysLabel,
        audienceSize,
        maximumCostSum,
        sliderPercentage,
        spend,
        impressions,
        ctr,
        clicks,
        leads,
    };
}
