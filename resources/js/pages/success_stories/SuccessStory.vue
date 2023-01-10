<template>
    <div class="border-t-4 border-zinc-300 card bg-base-100 shadow-lg rounded-xl hover:border-primary hover:shadow-xl duration-500 transition-all mx-4 lg:mx-0">
        <div class="grid auto-rows-min lg:grid-cols-3 card-body p-12 gap-10">
            <div class="flex flex-row justify-between lg:flex-col lg:col-span-1 font-medium">
                <div class="pr-4">
                    <div class="text-xl font-bold text-primary">Client in</div>
                    <div class="text-3xl text-zinc-900 my-1">{{ item.client_industry }}</div>
                    <div class="text-xl font-bold text-zinc-400">industry</div>

                    <div class="mt-4 text-lg text-zinc-700">From {{ item.client_city }}</div>
                </div>

                <div class="divider hidden lg:flex"></div>

                <div>
                    <div class="mt-4 text-lg text-zinc-700">
                        Campaign active since:
                        <span class="font-bold ml-2">{{ date(item.campaign_active_since) }}</span>
                    </div>
                    <div class="mt-2 text-lg text-zinc-700">
                        Total traffic value received:
                        <span class="font-bold ml-2">{{ money(trafficValue) }}</span>
                    </div>
                    <div class="mt-2 text-lg text-zinc-700">
                        Total campaign cost:
                        <span class="font-bold ml-2">{{ money(campaignCost) }}</span>
                    </div>
                    <div class="mt-2 text-lg text-zinc-700">
                        Profit / savings:
                        <span class="font-bold ml-2">{{ money(savings) }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="flex flex-row flex-wrap gap-3 mb-4">
                    <div v-for="(_, keywordId, index) in item.keywords"
                         class="btn btn-sm px-4 py-3 h-auto"
                         :class="{'btn-primary': keywordId === currentKeywordId}"
                         :key="`keyword-${keywordId}`"
                         @click="currentKeywordId = keywordId">{{ `Keyword ${index+1}` }}</div>
                </div>

                <Line :chartData="chartData" :chartOptions="chartOptions" :height="160" css-classes="w-full h-auto"></Line>
            </div>
        </div>
    </div>
</template>

<script>
import {Line} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, LinearScale, LineElement, PointElement, Legend} from 'chart.js';
import max from "lodash/max";

ChartJS.register(Legend, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "SuccessStory",

    components: {Line},

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
            campaignCost: this.item.monthly_fee,
            savings: 0,

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
                plugins: {
                    legend: {
                        display: true,
                        position: 'chartArea',
                        align: 'end',
                        labels: {
                            boxWidth: 14,
                            boxHeight: 14,
                        },
                    },
                    tooltip: {
                        enabled: true,
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
                        reverse: true,
                        beginAtZero: true,
                        min: 0,
                        max: 100,
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
                        ticks: {
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
            // 1. clear
            this.chartData.labels = [];
            this.chartData.datasets[0].data = [];
            this.chartData.datasets[1].data = [];

            // 2. populate
            this.item.keywords[this.currentKeywordId]
                .forEach(item => {
                    this.chartData.labels.push(
                        this.date(item.date)
                    );
                    this.chartData.datasets[0].data.push(item.ranking);

                    // monthly search volume/30 * cpc * ctr at rank
                    const trafficValue = (item.keyword_search_volume / 30) * Number(item.keyword_cpc) * Number(this.item.ctr);
                    // note: keyword_search_volume and keyword_cpc mostly doesn't change
                    this.chartData.datasets[1].data.push(trafficValue);
                });
            console.log(this.chartData.datasets[1].data);

            this.trafficValue = this.chartData.datasets[1].data.reduce((total, b) => total + b, 0);

            // 3. convert to percentage, since values are so different (without this rank will look like a strait line)
            // ranking
            let maximum = max(this.chartData.datasets[0].data);
            this.chartData.datasets[0].data = this.chartData.datasets[0].data.map(i => i / maximum * 100);

            // traffic value
            maximum = max(this.chartData.datasets[1].data);
            this.chartData.datasets[1].data = this.chartData.datasets[1].data.map(i => 100 - (i / maximum * 100));
        },
    },
}
</script>
