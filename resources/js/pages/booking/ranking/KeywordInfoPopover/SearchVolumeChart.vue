<template>
    <Bar :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Bar>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';
import orderBy from 'lodash/orderBy';

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
    name: "SearchVolumeChart",

    components: {Bar},

    props: {
        items: {
            type: Array,
            required: true,
        },
    },

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
                            autoSkipPadding: 10,
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
        items: {
            handler(items) {
                const newItems = items.map(i => {
                    i.key = `${i.year}` + (i.month < 10 ? '0' + i.month : i.month);
                    return i;
                });
                const sortedItems = orderBy(newItems, 'key');

                this.chartData.labels = sortedItems.map(i => months[i.month]);
                this.chartData.datasets[0].data = sortedItems.map(i => i.search_volume);
            },
            deep: true,
        },
    },
}
</script>
