<template>
    <Line :chartData="chartData" :chartOptions="chartOptions" :height="200" css-classes="w-full h-auto"></Line>
</template>

<script>
import {Line} from 'vue-chartjs';
import {Chart as ChartJS, Tooltip, PointElement, LineElement, CategoryScale, LinearScale, Filler} from 'chart.js';

ChartJS.register(Tooltip, CategoryScale, LinearScale, PointElement, LineElement, Filler);

export default {
    name: "HowItWorksChart",

    components: {Line},

    props: {
        labels: {
            type: Array,
            required: true,
        },
        data: {
            type: Array,
            required: true,
        },
    },

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
                },
                scales: {
                    y: {
                        ticks: {
                            color: "rgba(255, 255, 255, 1)",
                        },
                        grid: {
                            display: false,
                            borderColor: 'transparent',
                        },
                    },
                    x: {
                        ticks: {
                            color: "rgba(255, 255, 255, 1)",
                        },
                        grid: {
                            color: "rgba(255, 255, 255, .2)",
                            borderDash: [5, 5],
                            borderColor: "rgba(255, 255, 255, .2)",
                        },
                    }
                },
            },
        };
    },

    mounted() {
        this.chartData = {
            labels: this.labels,
            datasets: [
                {
                    label: '',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    borderColor: "rgba(255, 255, 255, 1)",
                    pointBackgroundColor: "rgba(255, 255, 255, 1)",
                    data: this.data,
                    fill: 'start',
                    tension: 0.4,
                }
            ]
        };
    },
}
</script>
