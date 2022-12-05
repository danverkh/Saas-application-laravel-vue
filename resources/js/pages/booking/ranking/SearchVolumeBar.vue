<template>
    <div class="w-full bg-zinc-400 my-3 rounded-xl overflow-hidden">
        <div class="bg-accent text-[11px] text-white text-left px-2.5 font-medium" :style="{width: `${percentage}%`}">
            {{ value }}
        </div>
    </div>
</template>

<script>
import {useRankingItemsStore} from "@/stores/rankingItems";

export default {
    name: "SearchVolumeBar",

    props: {
        value: {
            required: true,
            type: Number,
        },
    },

    computed: {
        percentage() {
            return (this.value / this.max * 100).toFixed(2);
        },

        max() {
            return useRankingItemsStore().max.searchVolume;
        },
    },
}
</script>
