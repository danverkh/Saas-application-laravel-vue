<template>
    <div class="grid gap-y-5">
        <div class="grid gap-y-3">
            <div class="flex items-end justify-between">
                <div class="text-xl">Clients out of 10 Leads</div>
                <div class="font-bold text-2xl">{{ leads }}</div>
            </div>
            <input v-model="leads" type="range" min="1" max="10" class="range range-lg range-primary" />
            <div class="w-full flex justify-between text-xs px-2 h-2 overflow-hidden -mt-1.5 opacity-50">
                <span v-for="_ in 10">|</span>
            </div>
        </div>

        <div class="flex flex-col flex-nowrap gap-y-3">
            <div class="flex items-end justify-between">
                <div class="text-xl">Value of one client</div>
                <div class="font-bold text-2xl whitespace-nowrap">{{ money(clientValue) }}</div>
            </div>
            <input v-model="clientValue" type="range" min="10" max="10000" class="range range-lg range-primary" />
        </div>
    </div>

    <div class="flex flex-col items-center md:flex-row mt-8">
        <div class="grid items-center w-full md:w-1/2">
            <div class="text-xl -mr-10 space-y-2 mb-6 md:mb-0">
                <div class="text-2xl md:text-3xl leading-relaxed">
                    After 12 months you would have gained <span class="font-bold">{{ newClients }}</span> clients
                    and generated an additional profit of <span class="font-bold">{{ money(newProfit, {precision: 0}) }}</span>.
                </div>
            </div>
        </div>

        <div class="card flex flex-row flex-nowrap bg-primary shadow-lg shadow-strong rounded-2xl p-4 md:w-1/2 md:-right-20 max-w-xs relative">
            <Bar
                :chartData="chartData1"
                :chartOptions="chartOptions1"
                :height="700"
                css-classes="w-1/2"
            />
            <Bar
                :chartData="chartData2"
                :chartOptions="chartOptions2"
                :height="700"
                css-classes="w-1/2"
            />
        </div>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';
import round from "lodash/round";
import cloneDeep from "lodash/cloneDeep";

ChartJS.register(CategoryScale, BarElement);

export default {
    name: "PricingClientsAndValueCalculator",

    components: {Bar},

    data() {
        return {
            leads: 2,
            clientValue: 3000,
            chartData1: {
                labels: ['Clients'],
                datasets: [
                    {
                        backgroundColor: ['#2F2E41'],
                        borderRadius: 5,
                        data: [],
                    },
                ],
            },
            chartData2: {
                labels: ['Profit'],
                datasets: [
                    {
                        backgroundColor: ['#3B82F6'],
                        borderRadius: 5,
                        data: [],
                    },
                ],
            },
            chartOptions1: {
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
                        position: 'left',
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            display: true,
                            autoSkipPadding: 10,
                            font: {
                                size: 10,
                            },
                            color: 'rgba(255, 255, 255, 0.9)',
                        },
                        grid: {
                            display: true,
                            drawOnChartArea: false,
                            color: 'rgba(255, 255, 255, 1)',
                            borderColor: 'rgba(255, 255, 255, 0.8)',
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
                            borderColor: 'rgba(255, 255, 255, .6)',
                        },
                    },
                },
            },
            chartOptions2: {},
        };
    },

    created() {
        this.chartOptions2 = cloneDeep(this.chartOptions1);
        this.chartOptions2.scales.y.position = 'right';
        this.chartOptions2.scales.y.max = 100000;
    },

    mounted() {
        this.populateCharts();
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
            this.populateCharts();
        },

        clientValue() {
            this.populateCharts();
        },
    },

    methods: {
        populateCharts() {
            this.chartData1.datasets[0].data = [this.newClients];
            this.chartData2.datasets[0].data = [this.newProfit];
        },
    },
}
</script>
