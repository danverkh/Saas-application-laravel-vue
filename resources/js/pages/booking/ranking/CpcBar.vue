<template>
    <div class="w-full bg-zinc-400 my-3 rounded-xl overflow-hidden">
        <div class="bg-primary text-xs text-white text-left px-2.5 font-medium" :style="{width: `${percentage}%`}">
            {{ value ? money(value) : '-' }}
        </div>
    </div>
</template>

<script>
import {useRankingItemsStore} from "@/stores/rankingItems";

export default {
    name: "CpcBar",

    props: {
        value: {
            required: true,
            type: Number,
        },
    },

    computed: {
        percentage() {
            return this.value
                ? (this.value / this.max * 100).toFixed(2)
                : 0;
        },

        max() {
            return useRankingItemsStore().max.cpc;
        },
    },
}
</script>
