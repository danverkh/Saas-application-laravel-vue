<template>
    <div class="overflow-x-auto">
        <table class="table table-compact table-zebra w-full">
            <thead>
            <tr>
                <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary" :disabled="loading"/></th>
                <th>Keyword</th>
                <th>Ranking</th>
                <th>Clicks</th>
                <th>Searches</th>
                <th>Competition</th>
                <th>CPC</th>
                <th>URL</th>
            </tr>
            </thead>
            <tbody>
            <template v-if="!failed">
                <tr v-if="!loading">
                    <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary"/></th>
                    <th>1</th>
                    <td>Cy Ganderton</td>
                    <td>Quality Control Specialist</td>
                    <td>Littel, Schaden and Vandervort</td>
                    <td>Canada</td>
                    <td>12/16/2020</td>
                    <td>Blue</td>
                </tr>

                <tr v-else>
                    <td colspan="8" class="text-center !py-12">
                        <spinner></spinner>
                    </td>
                </tr>
            </template>

            <tr v-if="failed">
                <td colspan="8" class="text-center !py-12">
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
            failed: false,
            rows: [],
        };
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;
            this.failed = false;

            axios.get(route('api.rankings'), {params: {market: this.market, query: this.query}})
                .then(resp => {
                    this.rows = resp.data.rows;
                })
                .catch(error => {
                    this.failed = true;

                    if (error.response.status === 429) {
                        alert('Too many search attempts, please try again in a minute.');
                    } else {
                        alert('Whoops, something went wrong... Please try again later.');
                        console.error('Failed to fetch rankings', error);
                    }
                })
                .finally(() => this.loading = false);
        },
    },
}
</script>
