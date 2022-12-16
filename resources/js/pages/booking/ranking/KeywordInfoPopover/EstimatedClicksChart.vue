<template>
    <Bar :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Bar>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';

ChartJS.register(CategoryScale, BarElement);

export default {
    name: "EstimatedClicksChart",

    components: {Bar},

    props: {
        value: {
            type: Number,
            required: true,
        },
    },

    data() {
        return {
            chartData: {
                labels: ['Currently', 'Expected'],
                datasets: [
                    {
                        backgroundColor: ['#ef4443', '#3cc55e'],
                        borderRadius: 5,
                        data: [],
                    },
                ],
            },
            chartOptions: {
                indexAxis: 'y',
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
                            autoSkipPadding: 10,
                            font: {
                                size: 11,
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
        value(value) {
            this.chartData.datasets[0].data = [value * 0.25, value];
        },
    },
}
</script>
