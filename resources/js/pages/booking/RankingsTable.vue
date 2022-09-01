<template>
    <div class="overflow-x-auto">
        <table class="table table-compact table-zebra w-full">
            <thead>
            <tr>
                <th><input type="checkbox" class="checkbox checkbox-xs bg-white rounded text-primary"/></th>
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
            <tr v-if="loading">
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
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
import Spinner from '@/components/Spinner.vue';

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
            axios.get(route('api.rankings'), {params: {market: this.market, query: this.query}})
                .then(resp => {
                    this.rows = resp.data.rows;
                })
                .catch(error => {
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
