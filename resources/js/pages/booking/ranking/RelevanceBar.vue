<template>
    <div v-if="!requestPending" @click="fetch" class="w-full bg-zinc-400 h-4 rounded-xl overflow-hidden min-w-[50px] relative">
        <div class="text-xs text-white px-2.5 font-medium relative z-10 text-left">{{ percentage }}%</div>
        <div class="bg-[#cfbe00] h-full transition-all duration-1000 ease-out absolute top-0 left-0" :style="{right: `${100 - percentage}%`}"></div>
    </div>

    <div v-else class="text-center">
        <Spinner :size="12" :border-width="2.5" color="#a1a1aa" class="inline-block"></Spinner>
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
                    this.percentage = 0;

                    setTimeout(() => {
                        this.percentage = data.relevance;
                    }, 500);
                })
                .catch(error => {
                    console.error('Failed to fetch relevance for keyword', error);
                })
                .finally(() => this.requestPending = false);
        },
    },
}
</script>
