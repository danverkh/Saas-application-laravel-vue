<template>
    <Line :chartData="chartData" :chartOptions="chartOptions" :height="250" css-classes="w-full h-auto"></Line>
</template>

<script>
import {Line} from 'vue-chartjs';
import {Chart as ChartJS, Tooltip, PointElement, LineElement, CategoryScale, LinearScale} from 'chart.js';
import generator from "random-seed";
import {useCart} from "@/stores/cart";
import Helpers from "@/services/Helpers";

ChartJS.register(Tooltip, CategoryScale, LinearScale, PointElement, LineElement);

export default {
    name: "CampaignProgressPredictionChart",

    components: {Line},

    data() {
        return {
            chartData: {
                labels: [],
                datasets: [],
            },
            chartOptions: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                return Helpers.ordinalNumber(context[0].label) + ' day';
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

    mounted() {
        let data = [
            0, 0, 0, 0, 0, 0, 0,
            11, 41, 69, 98, 132, 167, 193,
            230, 270, 295, 329, 358, 384, 402,
            424, 426, 427, 432, 435, 438, 441,
        ];

        this.chartData = {
            labels: [...Array(30).keys()].map(i => i + 1),
            datasets: [
                {
                    label: 'spend / cost',
                    borderColor: "rgba(221, 43, 70, 1)",
                    data: data.map(number => this.deterministicRandom('spend', number, 40)),
                    tension: 0.8,
                },
                {
                    label: 'traffic / clicks',
                    borderColor: "rgba(59, 130, 246, 1)",
                    data: data.map(number => this.deterministicRandom('traffic', number, 50)),
                    tension: 0.8,
                },
            ]
        };
    },

    methods: {
        deterministicRandom(name, number, amplify) {
            if (number === 0) return 0;

            if (number > 21) amplify /= 2;

            const seed = `${useCart().domain}.${name}.${number}`;

            return number + generator(seed).intBetween(0, Math.log10(number) * amplify);
        },
    },
}
</script>
