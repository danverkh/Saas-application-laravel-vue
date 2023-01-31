<template>
    <div class="grid gap-y-5">
        <div class="grid gap-y-3">
            <div class="flex items-end justify-between">
                <div>Clients out of 10 Leads:</div>
                <div class="font-bold text-xl">{{ leads }}</div>
            </div>
            <input v-model="leads" type="range" min="1" max="10" class="range range-primary" />
            <div class="w-full flex justify-between text-xs px-2 h-1.5 overflow-hidden -mt-1.5 opacity-50">
                <span v-for="_ in 10">|</span>
            </div>
        </div>

        <div class="flex flex-col flex-nowrap gap-y-3">
            <div class="flex items-end justify-between">
                <div>Value of one client:</div>
                <div class="font-bold text-xl">{{ money(clientValue) }}</div>
            </div>
            <input v-model="clientValue" type="range" min="10" max="10000" class="range range-primary" />
        </div>
    </div>

    <div class="flex flex-col items-center md:flex-row mt-8">
        <div class="grid items-center w-1/2">
            <div class="text-xl -mr-10 space-y-2 mb-6 md:mb-0">
                <div>
                    <div class="text-zinc-500">New clients:</div>
                    <div class="text-2xl">
                        <span class="font-bold">{{ newClients }}</span> per month
                    </div>
                </div>

                <div>
                    <div class="text-zinc-500">New profit:</div>
                    <div class="text-2xl">
                        <span class="font-bold">{{ money(newProfit, {precision: 0}) }}</span> per month
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-primary shadow-lg shadow-strong rounded-2xl p-4 md:w-1/2 md:-right-20 max-w-xs relative">
            <Bar
                :chartData="chartData"
                :chartOptions="chartOptions"
                :height="300"
                css-classes="w-full h-auto"
            />
        </div>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';
import round from "lodash/round";

ChartJS.register(CategoryScale, BarElement);

export default {
    name: "PricingClientsAndValueCalculator",

    components: {Bar},

    data() {
        return {
            leads: 2,
            clientValue: 3000,
            chartData: {
                labels: ['Clients', 'Profit'],
                datasets: [
                    {
                        backgroundColor: ['#2F2E41', '#3B82F6'],
                        borderRadius: 5,
                        data: [],
                    },
                ],
            },
            chartOptions: {
                indexAxis: 'x',
                animation: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: false,
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
                                size: 10,
                            },
                            color: 'rgba(255, 255, 255, 1)',
                        },
                        grid: {
                            display: true,
                            color: 'rgba(255, 255, 255, .4)',
                            borderDash: [5, 5],
                            borderColor: 'rgba(255, 255, 255, .4)',
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

    mounted() {
        this.populateChart();
    },

    computed: {
        newClients() {
            return round(this.leads);
        },

        newProfit() {
            return round(this.clientValue * this.newClients);
        },
    },

    watch: {
        leads() {
            this.populateChart();
        },

        clientValue() {
            this.populateChart();
        },
    },

    methods: {
        populateChart() {
            this.chartData.datasets[0].data = [this.newClients, this.newProfit];
        },
    },
}
</script>
