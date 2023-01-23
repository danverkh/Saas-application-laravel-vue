<template>
    <div class="border-t-4 border-zinc-300 card bg-base-100 shadow-lg rounded-xl hover:border-primary hover:shadow-xl duration-500 transition-all mx-4 lg:mx-0">
        <div class="grid auto-rows-min grid-cols-1 lg:grid-cols-3 card-body p-12 gap-10">
            <div class="flex flex-col col-span-1 md:flex-row justify-between lg:flex-col lg:col-span-1 font-medium">
                <div class="pr-4">
                    <div class="text-xl font-bold text-primary">Client in</div>
                    <div class="text-3xl text-zinc-900 my-1">{{ item.client_industry }}</div>
                    <div class="text-xl font-bold text-zinc-400">industry</div>

                    <div class="mt-4 text-lg text-zinc-700">
                        <span class="mr-2">From {{ item.client_city }}</span>
                        <CountryFlag :country="item.client_country" size="normal" class="rounded-md ring-2 ring-zinc-300"/>
                    </div>
                </div>

                <div class="divider hidden lg:flex mb-0"></div>

                <div class="text-base lg:text-lg text-zinc-700">
                    <div class="mt-3 md:mt-4">
                        Campaign active since:
                        <span class="font-bold ml-2">{{ date(item.campaign_active_since) }}</span>
                    </div>
                    <div class="mt-1 md:mt-2">
                        Total traffic value received:
                        <span class="font-bold ml-2 whitespace-nowrap">{{ money(trafficValue) }}</span>
                    </div>
                    <div class="mt-1 md:mt-2">
                        Total campaign cost:
                        <span class="font-bold ml-2 whitespace-nowrap">{{ money(campaignCost) }}</span>
                    </div>
                    <div class="mt-1 md:mt-2">
                        Profit / savings:
                        <span class="font-bold ml-2 whitespace-nowrap">{{ money(savings) }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="flex flex-row flex-wrap gap-2 md:gap-3 mb-4">
                    <div v-for="(_, keywordId, index) in item.keywords"
                         class="btn btn-sm h-auto md:btn-md"
                         :class="{'btn-primary': keywordId === currentKeywordId}"
                         :key="`keyword-${keywordId}`"
                         @click="currentKeywordId = keywordId">{{ `Keyword ${index+1}` }}</div>
                </div>

                <Line :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Line>
            </div>
        </div>
    </div>
</template>

<script>
import {Line} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, LinearScale, LineElement, PointElement, Legend} from 'chart.js';
import CountryFlag from 'vue-country-flag-next';
import dayjs from "dayjs";

ChartJS.register(Legend, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "SuccessStory",

    components: {Line, CountryFlag},

    props: {
        item: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            currentKeywordId: null,
            trafficValue: 0,

            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'rank',
                        borderColor: "rgba(221, 43, 70, 1)",
                        data: [],
                        tension: 0.5,
                    },
                    {
                        label: 'traffic value',
                        borderColor: "rgba(59, 130, 246, 1)",
                        data: [],
                        tension: 0.5,
                    },
                ]
            },
            chartOptions: {
                animation: false,
                plugins: {
                    // decimation: {
                    //     enabled: true,
                    //     algorithm: 'lttb',
                    //     samples: 20,
                    // },
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 14,
                            boxHeight: 14,
                        },
                    },
                    tooltip: {
                        enabled: false,
                        callbacks: {
                            labelColor: function (context) {
                                return {
                                    backgroundColor: (context.dataset.label === 'rank')
                                        ? 'rgba(221, 43, 70, 1)'
                                        : 'rgba(59, 130, 246, 1)',
                                    borderWidth: 2,
                                };
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        display: false,
                        // reverse: true,
                        // beginAtZero: true,
                        min: 0,
                        max: 115,
                        ticks: {
                            display: true,
                            color: 'rgba(120, 120, 120, 1)',
                        },
                        grid: {
                            display: true,
                            color: 'rgba(120, 120, 120, .2)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(120, 120, 120, .2)',
                        },
                    },
                    x: {
                        display: true,
                        ticks: {
                            display: true,
                            color: 'rgba(120, 120, 120, 1)',
                        },
                        grid: {
                            color: 'rgba(120, 120, 120, .2)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(120, 120, 120, .2)',
                        },
                    },
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false,
                },
                elements: {
                    point: {
                        radius: 2,
                    },
                },
            },
        };
    },

    computed: {
        campaignCost() {
            return this.item.monthly_fee * this.monthsCount;
        },

        monthsCount() {
            return this.chartData.datasets[0].data.length / 30;
        },

        savings() {
            return this.trafficValue - this.campaignCost;
        },
    },

    watch: {
        currentKeywordId() {
            this.populateChartWithSelectedKeywordData();
        },
    },

    mounted() {
        this.currentKeywordId = Object.keys(this.item.keywords)[0];
    },

    methods: {
        populateChartWithSelectedKeywordData() {
            let date = dayjs(this.item.campaign_active_since, 'YYYY-MM-DD');
            this.chartData.labels = this.item.chart[this.currentKeywordId].ranking.map((_, index) => date.add(index, 'day').format('DD.MM.YYYY'));

            this.chartData.datasets[0].data = this.item.chart[this.currentKeywordId].ranking;
            this.chartData.datasets[1].data = this.item.chart[this.currentKeywordId].trafficValue;

            this.trafficValue = this.chartData.datasets[1].data.reduce((total, b) => total + b, 0);
        },
    },
}
</script>
