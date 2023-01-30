<template>
    <div class="grid gap-y-5">
        <div class="grid gap-y-3">
            <div class="flex items-end justify-between">
                <div>Clients out of 10 Leads:</div>
                <div class="font-bold text-xl">{{ money(leads) }}</div>
            </div>
            <input v-model="leads" type="range" min="1" max="10" class="range range-primary" />
        </div>

        <div class="flex flex-col flex-nowrap gap-y-3">
            <div class="flex items-end justify-between">
                <div>Value of one client:</div>
                <div class="font-bold text-xl">{{ money(clientValue) }}</div>
            </div>
            <input v-model="clientValue" type="range" min="1" max="10000" class="range range-primary" />
        </div>
    </div>

    <div class="card bg-primary w-[120%] shadow-lg shadow-strong rounded-2xl p-4 my-5 relative right-0 top-4">
        <Bar :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Bar>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';

ChartJS.register(CategoryScale, BarElement);

export default {
    name: "PricingClientsAndValueCalculator",

    components: {Bar},

    data() {
        return {
            leads: 2,
            clientValue: 3000,
            chartData: {
                labels: [''],
                datasets: [
                    {
                        backgroundColor: ['#ef4443'],
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
                            color: 'rgba(255, 255, 255, 1)',
                        },
                        grid: {
                            display: true,
                            color: 'rgba(255, 255, 255, .2)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(255, 255, 255, .2)',
                        },
                    },
                    x: {
                        ticks: {
                            display: true,
                            font: {
                                size: 9,
                            },
                            color: 'rgba(255, 255, 255, 1)',
                        },
                        grid: {
                            display: false,
                            color: 'rgba(255, 255, 255, .2)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(255, 255, 255, .2)',
                        },
                    },
                },
            },
        };
    },
}
</script>

<style scoped>

</style>
