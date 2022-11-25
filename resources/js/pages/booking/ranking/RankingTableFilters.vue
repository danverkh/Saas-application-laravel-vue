<template>
    <div class="p-7 pb-6">
        <Input placeholder="Filter keywords" v-model="keyword" @change="debouncedFilter" class="text-zinc-900 text-base"/>
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
