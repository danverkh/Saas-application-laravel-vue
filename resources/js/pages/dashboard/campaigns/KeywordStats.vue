<template>
    <div class="bg-accent inline-block px-5 py-6 text-white min-w-[150px]">
        <div class="text-sm font-light flex">
            Clicks
            <svg class="w-3.5 h-3.5 mt-1 ml-1" width="32" height="32" viewBox="0 0 32 32">
                <path fill="currentColor" d="m24 12l-8 10l-8-10z"/>
            </svg>
        </div>
        <div class="text-3xl font-normal mt-1">{{ clicks }}</div>
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
        <div class="text-3xl font-normal mt-1">{{ cpc ? money(cpc) : 'N/A' }}</div>
    </div>

    <div class="inline-block px-5 py-6 text-zinc-800 min-w-[150px] border-r">
        <div class="text-sm font-light flex">Cost</div>
        <div class="text-3xl font-normal mt-1">{{ spendSum ? money(spendSum) : 'N/A' }}</div>
    </div>
</template>

<script>
import EventBus from "@/services/EventBus";
import {useDashboardCampaignStore} from "@/stores/dashboard/campaign";
import dayjs from "dayjs";

export default {
    name: "KeywordStats",

    data() {
        return {
            impressionsSum: 0,
            spendSum: 0,
            averageCpc: 0,
        };
    },

    computed: {
        cpc() {
            return useDashboardCampaignStore().data.cpc;
        },

        clicks() {
            const rankings    = useDashboardCampaignStore().data.rankings;
            const currentRank = rankings[dayjs().format('YYYY-MM-DD')]
                || rankings[dayjs().subtract(1, 'day').format('YYYY-MM-DD')]
                || null;

            if (currentRank === null) {
                return 'N/A';
            }

            let multiplier;

            if (currentRank === 1) {
                multiplier = 0.95;
            } else if (currentRank === 2) {
                multiplier = 0.9;
            } else if (currentRank === 3) {
                multiplier = 0.8;
            } else {
                const amount = (currentRank > 10) ? 0.3 : 0.06;

                multiplier = Math.max(1 - (currentRank * amount), 0.01);
            }

            return Math.round(useDashboardCampaignStore().data.search_volume * multiplier);
        },
    },

    beforeCreate() {
        EventBus.on('impressions.sum', sum => this.impressionsSum = sum);
        EventBus.on('spend.sum', sum => this.spendSum = sum);
    },
}
</script>
