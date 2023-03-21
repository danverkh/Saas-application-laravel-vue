<template>
    <div class="card w-full bg-base-100 shadow-lg rounded-xl border border-zinc-100">
        <div class="flex justify-between w-full bg-zinc-300 py-3 md:py-4 px-5 md:px-7">
            <div class="flex flex-col space-y-1 md:space-y-0 md:flex-row md:space-x-4">
                <div>
                    <div class="text-zinc-600 text-xs md:text-sm">Domain</div>
                    <div class="text-zinc-800 text-xl md:text-2xl font-medium">{{ selected.domain }}</div>
                </div>

                <div class="divider divider-vertical md:divider-horizontal"></div>

                <div>
                    <div class="text-zinc-600 text-xs md:text-sm">Keyword</div>
                    <div class="text-xl md:text-2xl font-medium text-primary">{{ selected.keyword }}</div>
                </div>
            </div>

            <div class="flex items-center">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="bg-zinc-600">
                        <svg class="w-6 h-6 cursor-pointer hover:text-zinc-900" width="32" height="32" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 !z-0 rounded-box w-52 mt-2">
                        <li>
                            <button class="text-red-600" @click="cancelKeyword">
                                <svg class="w-4 h-4 md:w-5 md:h-5 cursor-pointer text-red-600" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/>
                                </svg>
                                Cancel keyword
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="relative">
            <div v-if="loading" class="absolute inset-0 grid place-items-center backdrop-blur-[5px] bg-white-500/75">
                <spinner :size="55" :border-width="7" />
            </div>

            <div class="border-b border-zinc-200 grid grid-cols-2 md:block">
                <keyword-stats />
            </div>

            <div class="flex flex-col lg:flex-row gap-6 md:gap-10 p-6 md:p-10 pt-7">
                <div class="w-full lg:w-1/2">
                    <div class="text-md md:text-xl font-medium text-zinc-700 text-center mb-2">Ranking improvement</div>
                    <keyword-ranking-improvement-chart />
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="text-md md:text-xl font-medium text-zinc-700 text-center mb-2">Estimated clicks & traffic</div>

                    <campaign-progress-prediction-chart
                        :value="data.keyword"
                        :data="data"
                        :options="{yAxis: true}"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from "pinia";
import {useDashboardCampaignStore} from "@/stores/dashboard/campaign";
import KeywordStats from "@/pages/dashboard/campaigns/KeywordStats.vue";
import KeywordRankingImprovementChart from "@/pages/dashboard/campaigns/KeywordRankingImprovementChart.vue";
import CampaignProgressPredictionChart from "@/components/charts/CampaignProgressPredictionChart.vue";
import Spinner from "@/components/Spinner.vue";
import Modal from "@/services/Modal";

export default {
    name: "CampaignKeyword",

    components: {Spinner, CampaignProgressPredictionChart, KeywordRankingImprovementChart, KeywordStats},

    computed: {
        ...mapState(useDashboardCampaignStore, ['data', 'loading', 'selected']),
    },

    methods: {
        cancelKeyword() {
            Modal.open('cancel-keyword-confirmation');
        },
    },
}
</script>
