<template>
    <div class="grid gap-y-5">
        <div class="grid gap-y-3">
            <div class="flex items-end justify-between">
                <div>Your monthly budget:</div>
                <div class="font-bold text-xl">{{ money(budget) }}</div>
            </div>
            <input v-model="budget" type="range" min="0" max="2000" class="range range-primary" />
        </div>

        <div class="flex flex-col flex-nowrap gap-y-3">
            <div>Your industry:</div>
            <Select v-model="industry" :options="industryOptions"></Select>
        </div>
    </div>

    <div class="card bg-primary w-[120%] shadow-lg shadow-strong rounded-2xl p-4 my-5 relative -left-20 top-4">
        <Bar :chartData="chartData" :chartOptions="chartOptions" :height="150" css-classes="w-full h-auto"></Bar>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs';
import {CategoryScale, Chart as ChartJS, BarElement} from 'chart.js';

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
