<template>
    <Line :chartData="chartData" :chartOptions="chartOptions" :height="250" css-classes="w-full h-auto"></Line>
</template>

<script>
import {Line} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, LinearScale, LineElement, PointElement, Tooltip} from 'chart.js';
import generator from "random-seed";
import {useCart} from "@/stores/cart";
import {useForecastedResults} from "@/composables/useForecastedResults";
import {ref} from 'vue';
import dayjs from "dayjs";
import Helpers from "@/services/Helpers";

ChartJS.register(Tooltip, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "CampaignProgressPredictionChart",

    components: {Line},

    props: {
        value: {
            type: String,
            default: null,
        },
        data: {
            type: Object,
            default: null,
        },
        options: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            // 1. percentage of the random number
            // 2. minimum value amplifier
            // 3. maximum value amplifier
            dataProgression: [
                [0, 1, 1], [0, 1, 1], [0, 1, 1], [0, 1, 1], [0, 1, 1], [0, 1, 1], [0, 1, 1],                          // week 1
                [10, 1.2, 1], [15, 1.2, 1], [22, 1.2, 1], [26, 1.2, 1], [32, 1.2, 1], [37, 1.2, 1], [45, 1.2, 1],     // week 2
                [56, 1.6, 1], [65, 1.6, 1], [72, 1.6, 1], [79, 1.6, 1], [85, 1.6, 1], [89, 1.6, 1], [95, 1.6, 1],     // week 3
                [96, 1.8, 1], [97, 1.8, 1], [98, 1.8, 1], [99, 1.8, 1], [100, 1.8, 1], [100, 1.8, 1], [100, 1.8, 1],  // week 4
            ],
            chartData: {
                labels: [...Array(30).keys()].map(i => i),
                datasets: [
                    {
                        label: 'spend / cost',
                        borderColor: "rgba(221, 43, 70, 1)",
                        data: [],
                        tension: 0.5,
                    },
                    {
                        label: 'traffic / clicks',
                        borderColor: "rgba(59, 130, 246, 1)",
                        data: [],
                        tension: 0.5,
                    },
                ]
            },
            chartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                if (context[0].label === '0') return 'Today';

                                const date  = dayjs().add(context[0].label, 'day').format('MMMM D YYYY');
                                const parts = date.split(' ');

                                return parts[0] + ' ' + Helpers.ordinalNumber(parts[1]) + ' ' + parts[2];
                            },
                            label: function (context) {
                                let symbol = '';

                                if (context.datasetIndex === 0) {
                                    symbol = '€';
                                }
                                return `${context.dataset.label}: ${context.formattedValue} ${symbol}`;
                            },
                            labelColor: function (context) {
                                return {
                                    backgroundColor: (context.dataset.label === 'spend / cost')
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
                        ticks: {
                            display: this.options.yAxis || false,
                            color: 'rgba(120, 120, 120, 1)',
                        },
                        grid: {
                            display: this.options.yAxis || false,
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

    computed: {
        impressions() {
            return useForecastedResults(ref(1), this.data).impressions.value;
        },

        spend() {
            return useForecastedResults(ref(1), this.data).spend.value;
        },
    },

    watch: {
        impressions: {
            handler() {
                this.chartData.datasets[0].data = this.dataProgression.map((dayData, index) => this.deterministicRandom('spend', dayData, index));
            },
            deep: true,
            immediate: true,
        },

        spend: {
            handler() {
                this.chartData.datasets[1].data = this.dataProgression.map((dayData, index) => this.deterministicRandom('impressions', dayData, index));
            },
            deep: true,
            immediate: true,
        },
    },

    methods: {
        deterministicRandom(name, dayData, index) {
            const maxPercentage = dayData[0];
            const minAmplifier  = dayData[1];
            const maxAmplifier  = dayData[2];

            if (maxPercentage === 0) return 0;

            const value = this.value || useCart().domain;
            const seed = `${value}.${name}.${index}`;

            let min = this[name].min * minAmplifier;
            let max = this[name].max * maxAmplifier;

            if (min > max) min = max;

            const random = generator(seed).intBetween(min, max);

            return Math.ceil(random * (maxPercentage / 100));
        },
    },
}
</script>
