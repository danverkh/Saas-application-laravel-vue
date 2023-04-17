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
                <div class="dropdown dropdown-end z-10">
                    <label tabindex="0" class="bg-zinc-600">
                        <div class="p-1 hover:bg-zinc-400 hover:bg-opacity-25 rounded-lg">
                            <svg class="w-6 h-6 cursor-pointer hover:text-zinc-900" width="32" height="32" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z"/>
                            </svg>
                        </div>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 !z-0 rounded-box w-60 mt-2">
                        <li v-if="data.termination_date !== null">
                            <button @click="reactivateKeyword" class="group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="w-4 h-4 md:w-5 md:h-5 cursor-pointer text-blue-600 group-active:text-white">
                                    <path fill="currentColor" d="M18 10h-4V6a2 2 0 0 0-4 0l.071 4H6a2 2 0 0 0 0 4l4.071-.071L10 18a2 2 0 0 0 4 0v-4.071L18 14a2 2 0 0 0 0-4z"/>
                                </svg>
                                Reactivate keyword
                            </button>
                        </li>
                        <li v-if="data.termination_date === null">
                            <button @click="cancelKeyword" class="text-red-600 active:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="w-4 h-4 md:w-5 md:h-5 cursor-pointer fill-current">
                                    <path fill="currentColor" d="M12 4c-4.411 0-8 3.589-8 8s3.589 8 8 8s8-3.589 8-8s-3.589-8-8-8zm-5 8c0-.832.224-1.604.584-2.295l6.711 6.711A4.943 4.943 0 0 1 12 17c-2.757 0-5-2.243-5-5zm9.416 2.295L9.705 7.584A4.943 4.943 0 0 1 12 7c2.757 0 5 2.243 5 5c0 .832-.224 1.604-.584 2.295z"/>
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
        reactivateKeyword() {
            Modal.open('reactivate-keyword-confirmation');
        },

        cancelKeyword() {
            Modal.open('cancel-keyword-confirmation');
        },
    },
}
</script>
