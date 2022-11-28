<template>
    <div class="p-7 pb-6 relative md:max-w-md">
        <svg class="w-6 h-6 text-zinc-400 absolute left-11 top-10" width="32" height="32" viewBox="0 0 24 24">
            <path fill="currentColor" d="m21 19l-5.154-5.154a7 7 0 1 0-2 2L19 21l2-2zM5 10c0-2.757 2.243-5 5-5s5 2.243 5 5s-2.243 5-5 5s-5-2.243-5-5z"/>
        </svg>

        <Input placeholder="Filter keywords" v-model="keyword" @change="debouncedFilter" class="text-zinc-900 text-base pl-14"/>
    </div>
</template>

<script>
import Input from "@/components/Input.vue";
import debounce from "lodash/debounce";
import {useRankingItemsStore} from "@/stores/rankingItems";

export default {
    name: "RankingTableFilters",

    components: {Input},

    data() {
        return {
            keyword: '',
        };
    },

    methods: {
        debouncedFilter: debounce(function () {
            this.setFilters();
        }, 300),

        setFilters() {
            useRankingItemsStore().filters.keyword.value = this.keyword;
        },
    },
}
</script>
