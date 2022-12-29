<template>
    <div>
        <div class="text-md">Target audience size</div>
        <div class="text-2xl font-semibold">
            <AnimateNumber :value="audienceSize"/>+
        </div>
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
        <div class="text-2xl font-semibold">{{ number(clicks.min, 0) }} - {{ number(clicks.max, 0) }}</div>
    </div>

    <div class="mb-4">
        <div class="text-md">
            {{ daysLabel }} leads
            <div class="badge bg-violet-600 border-none ml-2">Key Result</div>
        </div>
        <div class="text-2xl font-semibold">{{ number(leads.min, 0) }} - {{ number(leads.max, 0) }}</div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import {useForecastedResults} from "@/composables/useForecastedResults";
import AnimateNumber from '@/components/AnimateNumber.vue';

const days = ref(1);

const {
    daysLabel,
    audienceSize,
    maximumCostSum,
    sliderPercentage,
    spend,
    impressions,
    ctr,
    clicks,
    leads,
} = useForecastedResults(days);
</script>
