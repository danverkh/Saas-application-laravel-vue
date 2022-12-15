<template>
    <div class="bg-white rounded-lg shadow-lg py-5 px-6 w-80 h-80 pointer-events-none fixed z-50 hidden">
        <div class="font-semibold text-base mb-3">
            Search volume: {{ item.search_volume }}
        </div>
        <Bar :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Bar>

        <vue-speedometer
            :width="150"
            :height="150"
            :value="item.competition || 0"
            :min-value="0"
            :max-value="100"
            :segments="3"
            :segment-colors="['#e31d3b', '#efda11', '#25cb4b']"
            :needle-height-ratio="0.4"
            :ring-width="30"
            needle-color="#000"
            :max-segment-labels="0"
            current-value-text="${value}%"
        />
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';
import VueSpeedometer from "vue-speedometer";

ChartJS.register(CategoryScale, BarElement);

const months = {
    1: 'Jan',
    2: 'Feb',
    3: 'Mar',
    4: 'Apr',
    5: 'May',
    6: 'Jun',
    7: 'Jul',
    8: 'Aug',
    9: 'Sep',
    10: 'Oct',
    11: 'Nov',
    12: 'Dec',
};

export default {
    name: "KeywordInfoPopover",

    props: {
        item: {
            type: Object,
            required: true,
        },
    },

    components: {Bar, VueSpeedometer},

    data() {
        return {
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'ranking',
                        backgroundColor: "#22c55e",
                        borderRadius: 5,
                        data: [],
                    },
                ]
            },
            chartOptions: {
                animation: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {},
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            display: true,
                            font: {
                                size: 9,
                            },
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
                            display: true,
                            font: {
                                size: 9,
                            },
                            color: 'rgba(120, 120, 120, 1)',
                        },
                        grid: {
                            display: false,
                            color: 'rgba(120, 120, 120, .2)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(120, 120, 120, .2)',
                        },
                    },
                },
            },
        };
    },

    watch: {
        item: {
            handler(value) {
                this.chartData.labels = value.monthly_searches.map(i => months[i.month]);
                this.chartData.datasets[0].data = value.monthly_searches.map(i => i.search_volume);
            },
            deep: true,
        },
    },
}
</script>
