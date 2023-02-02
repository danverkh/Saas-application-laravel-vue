<template>
    <div class="grid gap-y-5">
        <div class="grid gap-y-3">
            <div class="flex items-end justify-between">
                <div>Your monthly budget:</div>
                <div class="font-bold text-xl">{{ money(budget) }}</div>
            </div>
            <input v-model="budget" type="range" min="10" max="2000" class="range range-primary"/>
        </div>

        <div class="flex flex-col flex-nowrap gap-y-3">
            <div>Your industry:</div>
            <Select v-model="industry" :options="industryOptions"></Select>
        </div>
    </div>

    <div class="flex flex-col-reverse items-center md:flex-row mt-7 mb-2">
        <div class="card flex flex-row flex-nowrap bg-primary shadow-lg shadow-strong rounded-2xl px-4 pt-4 pb-3 md:w-1/2 md:-left-20 max-w-xs">
            <Bar
                :chartData="chartData1"
                :chartOptions="chartOptions1"
                :height="700"
                css-classes="w-1/2"
                :class="{'opacity-0': industry === null}"
            />
            <Bar
                :chartData="chartData2"
                :chartOptions="chartOptions2"
                :height="700"
                css-classes="w-1/2"
                :class="{'opacity-0': industry === null}"
            />
        </div>

        <div class="grid items-center mb-6 md:mb-0 text-center md:text-left md:w-1/2">
            <div v-if="industry === null" class="text-zinc-700">Please select industry</div>
            <div v-else class="text-2xl md:-ml-10">
                We would expect <span class="font-bold">{{ visitors }}</span> website visitors and <span class="font-bold">{{ leads }}</span> hot leads.
            </div>
        </div>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';
import generator from "random-seed";
import round from 'lodash/round';
import cloneDeep from "lodash/cloneDeep";

ChartJS.register(CategoryScale, BarElement);

export default {
    name: "PricingVisitorsAndLeadsCalculator",

    components: {Bar},

    data() {
        return {
            budget: 500,
            industry: null,
            industryOptions: [
                {label: 'Business Consultancy', value: 'consultancy'},
                {label: 'Business Retail', value: 'retail'},
                {label: 'Consumer Goods/Services', value: 'consumer-goods-or-services'},
                {label: 'Education', value: 'education'},
                {label: 'Energy', value: 'energy'},
                {label: 'Event Planning', value: 'event-planning'},
                {label: 'Finance', value: 'finance'},
                {label: 'Forwarding', value: 'forwarding'},
                {label: 'Gambling', value: 'gambling'},
                {label: 'Health Care', value: 'health-care'},
                {label: 'Human Resources', value: 'human-resources'},
                {label: 'Information Technology', value: 'information-technology'},
                {label: 'Insurance', value: 'insurance'},
                {label: 'Interior', value: 'interior'},
                {label: 'Legal', value: 'legal'},
                {label: 'Manufacturing', value: 'manufacturing'},
                {label: 'Marketing', value: 'marketing'},
                {label: 'Physical Storage', value: 'physical-storage'},
                {label: 'Printing', value: 'printing'},
                {label: 'Private Investigation', value: 'private-investigation'},
                {label: 'Real Estate', value: 'real-estate'},
                {label: 'Recycling', value: 'recycling'},
                {label: 'Translation', value: 'translation'},
                {label: 'Travel', value: 'travel'},
                {label: 'Video Production', value: 'video-production'},
                {label: 'Other', value: 'other'},
            ],
            chartData1: {
                labels: ['Visitors'],
                datasets: [
                    {
                        backgroundColor: ['#2F2E41'],
                        borderRadius: 5,
                        data: [],
                    },
                ],
            },
            chartData2: {
                labels: ['Leads'],
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
    },

    mounted() {
        this.populateCharts();
    },

    computed: {
        visitors() {
            return round(this.budget * 0.56 * this.industryCoefficient);
        },

        leads() {
            return round(this.budget * 0.015 * this.industryCoefficient);
        },

        industryCoefficient() {
            if (this.industry === null) return 0;

            return generator(this.industry).floatBetween(0.9, 1.2);
        },
    },

    watch: {
        budget() {
            this.populateCharts();
        },

        industry() {
            this.populateCharts();
        },
    },

    methods: {
        populateCharts() {
            this.chartData1.datasets[0].data = [this.visitors];
            this.chartData2.datasets[0].data = [this.leads];
        },
    },
}
</script>
