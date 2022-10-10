<template>
    <Line :chartData="chartData" :chartOptions="chartOptions" :height="250" css-classes="w-full h-auto"></Line>
</template>

<script>
import {Line} from 'vue-chartjs';
import {Chart as ChartJS, Tooltip, PointElement, LineElement, CategoryScale, LinearScale} from 'chart.js';
import generator from "random-seed";
import {useCart} from "@/stores/cart";
import Helpers from "@/services/Helpers";
import {useForecastedResults} from "@/composables/useForecastedResults";
import {ref} from 'vue';

ChartJS.register(Tooltip, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "CampaignProgressPredictionChart",

    components: {Line},

    data() {
        return {
            dataProgression: [
                0, 0, 0, 0, 0, 0, 0,        // week 1
                85, 76, 96, 99, 91, 94, 92, // week 2
                87, 79, 81, 96, 92, 95, 84, // week 3
                31, 24, 16, 12, 12, 9, 5,   // week 4
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

                                return Helpers.ordinalNumber(context[0].label) + ' day';
                            },
                            label: function(context) {
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
                            display: false,
                        },
                        grid: {
                            display: false,
                            borderColor: 'transparent',
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
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
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
            return useForecastedResults(ref(1)).impressions.value;
        },

        spend() {
            return useForecastedResults(ref(1)).spend.value;
        },
    },

    watch: {
        impressions: {
            handler() {
                const data = this.dataProgression.map((number, index) => this.deterministicRandom('spend', number, index));

                for (let i = 0; i < this.dataProgression.length; i++) {
                    data[i] = (data[i - 1] || 0) + data[i];
                }
                this.chartData.datasets[0].data = data;
            },
            deep: true,
        },

        spend: {
            handler() {
                const data = this.dataProgression.map((number, index) => this.deterministicRandom('impressions', number, index));

                for (let i = 0; i < this.dataProgression.length; i++) {
                    data[i] = (data[i - 1] || 0) + data[i];
                }
                this.chartData.datasets[1].data = data;
            },
            deep: true,
        },
    },

    methods: {
        deterministicRandom(name, maxPercentage, index) {
            if (maxPercentage === 0) return 0;

            const seed = `${useCart().domain}.${name}.${index}.${maxPercentage}`;

            const random = generator(seed).intBetween(this[name].min, this[name].max);

            return Math.ceil(random * (maxPercentage / 100));
        },
    },
}
</script>
