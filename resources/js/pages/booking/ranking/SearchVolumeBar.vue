<template>
    <div class="w-full bg-zinc-400 h-4 rounded-xl overflow-hidden min-w-[50px] relative">
        <div class="bg-accent h-full transition-all duration-1000 ease-out absolute top-0 left-0" :style="{right: `${100 - percentage}%`}"></div>
        <div class="text-xs text-white px-2.5 font-medium relative text-left">{{ value }}</div>
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
