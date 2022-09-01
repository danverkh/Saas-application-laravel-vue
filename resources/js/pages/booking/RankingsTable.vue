<template>
    <div class="overflow-x-auto">
        <table class="table table-compact table-zebra w-full">
            <thead>
            <tr>
                <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary" :disabled="loading"/></th>
                <th>Keyword</th>
                <th>Search volume</th>
                <th>CPC</th>
                <th>Current rank</th>
                <th>Url</th>
                <th>Projected clicks</th>
                <th>Projected traffic</th>
                <th>Maximum cost</th>
            </tr>
            </thead>
            <tbody>
            <template v-if="!error">
                <template v-if="!loading">
                    <tr v-for="(row, index) in rows" :key="`table-row-${index}`">
                        <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary"/></th>
                        <th>{{ row.keyword }}</th>
                        <td>{{ row.search_volume }}</td>
                        <td>{{ row.cpc }}</td>
                        <td>{{ row.current_rank }}</td>
                        <td>{{ row.url }}</td>
                        <td>{{ row.projected_clicks }}</td>
                        <td>{{ row.projected_traffic }}</td>
                        <td>{{ row.maximum_cost }}</td>
                    </tr>
                </template>

                <tr v-else>
                    <td colspan="8" class="text-center !py-12">
                        <spinner></spinner>
                    </td>
                </tr>
            </template>

            <tr v-if="error">
                <td colspan="8" class="text-center !py-12">
                    <div class="text-red-600 text-base text-center mb-5">{{ error }}</div>

                    <button @click="fetch" class="btn gap-3 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-45">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Try again
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
import Spinner from '../../components/Spinner.vue';

export default {
    name: "RankingsTable",

    components: {Spinner},

    props: {
        market: String,
        query: String,
    },

    data() {
        return {
            loading: true,
            error: null,
            rows: [],
        };
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;
            this.error = null;

            axios.get(route('api.rankings'), {params: {market: this.market, query: this.query}})
                .then(resp => {
                    this.rows = resp.data.rows;
                })
                .catch(error => {
                    if (error.response.status === 429) {
                        this.error = 'Too many search attempts, please try again in a minute';
                    } else {
                        this.error = 'Whoops, something went wrong... Please try again later';
                        console.error('Failed to fetch rankings', error);
                    }
                })
                .finally(() => this.loading = false);
        },
    },
}
</script>
