<template>
    <div class="bg-accent inline-block px-5 py-6 text-white min-w-[150px]">
        <div class="text-sm font-light flex">
            Clicks
            <svg class="w-3.5 h-3.5 mt-1 ml-1" width="32" height="32" viewBox="0 0 32 32">
                <path fill="currentColor" d="m24 12l-8 10l-8-10z"/>
            </svg>
        </div>
        <div class="text-3xl font-normal mt-1">672</div>
    </div>

    <div class="bg-primary inline-block px-5 py-6 text-white min-w-[150px]">
        <div class="text-sm font-light flex">
            Impressions
            <svg class="w-3.5 h-3.5 mt-1 ml-1" width="32" height="32" viewBox="0 0 32 32">
                <path fill="currentColor" d="m24 12l-8 10l-8-10z"/>
            </svg>
        </div>
        <div class="text-3xl font-normal uppercase mt-1">{{ shortenNumber(impressionsSum) }}</div>
    </div>

    <div class="inline-block px-5 py-6 text-zinc-800 min-w-[150px] border-r">
        <div class="text-sm font-light flex">Avg. CPC</div>
        <div class="text-3xl font-normal mt-1">€0.96</div>
    </div>

    <div class="inline-block px-5 py-6 text-zinc-800 min-w-[150px] border-r">
        <div class="text-sm font-light flex">Cost</div>
        <div class="text-3xl font-normal mt-1">{{ money(spendSum) }}</div>
    </div>
</template>

<script>
import EventBus from "@/services/EventBus";

export default {
    name: "KeywordStats",

    data() {
        return {
            impressionsSum: 0,
            spendSum: 0,
            averageCpc: 0,
        };
    },

    watch: {

    },

    beforeCreate() {
        EventBus.on('impressions.sum', sum => this.impressionsSum = sum);
        EventBus.on('spend.sum', sum => this.spendSum = sum);
    },
}
</script>
