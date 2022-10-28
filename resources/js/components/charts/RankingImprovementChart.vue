<template>
    <Bar :chartData="chartData" :chartOptions="chartOptions" :height="250" css-classes="w-full h-auto"></Bar>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement, LinearScale, PointElement, Tooltip} from 'chart.js';

ChartJS.register(Tooltip, CategoryScale, BarElement, LinearScale, PointElement);

export default {
    name: "RankingImprovementChart",

    components: {Bar},

    data() {
        return {
            chartData: {
                labels: [...Array(30).keys()].map(i => i),
                datasets: [
                    {
                        label: 'ranking',
                        backgroundColor: "#22c55e",
                        data: [...Array(30).keys()].map(i => i).reverse(),
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

                        },
                    },
                },
                scales: {
                    y: {
                        reverse: true,
                        beginAtZero: true,
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
            },
        };
    },
}
</script>
