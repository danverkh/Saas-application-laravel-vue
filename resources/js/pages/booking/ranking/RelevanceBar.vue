<template>
    <div @click="fetch" class="w-full bg-zinc-400 my-3 rounded-xl overflow-hidden">
        <div class="bg-[#dccf42] text-xs text-white px-2.5 font-medium"
             :class="requestPending ? 'text-center' : 'text-left'"
             :style="{width: `${percentage}%`}">

            <div v-if="!requestPending">{{ percentage }}%</div>
            <Spinner v-else size="10" border-width="3" color="#fff"></Spinner>
        </div>
    </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";
import {useCart} from "@/stores/cart";

export default {
    name: "RelevanceBar",

    components: {Spinner},

    props: {
        item: {
            required: true,
            type: Object,
        },
    },

    data() {
        return {
            percentage: 0,
            requestPending: false,
        };
    },

    methods: {
        fetch() {
            this.requestPending = true;

            const params = {
                keyword: this.item.keyword,
                rank: this.item.rank,
                url: this.item.url,
                market: useCart().market,
                domain: useCart().domain,
            };

            axios.get(route('api.keyword.relevance'), {params})
                .then(({data}) => {
                    this.percentage = data.relevance;
                })
                .catch(error => {
                    console.error('Failed to fetch relevance for keyword', error);
                })
                .finally(() => this.requestPending = false);
        },
    },
}
</script>
