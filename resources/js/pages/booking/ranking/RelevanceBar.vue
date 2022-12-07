<template>
    <div v-if="item.relevance !== null" class="w-full bg-zinc-400 h-4 rounded-xl overflow-hidden min-w-[50px] relative">
        <div class="text-xs text-white px-2.5 font-medium relative z-10 text-left">{{ item.relevance }}%</div>
        <div class="bg-[#cfbe00] h-full transition-all duration-1000 ease-out absolute top-0 left-0" :style="{right: `${100 - item.relevance}%`}"></div>
    </div>

    <div v-else class="text-center">
        <Spinner :size="12" :border-width="2.5" color="#a1a1aa" class="inline-block"></Spinner>
    </div>
</template>

<script>
import Spinner from "@/components/Spinner.vue";

export default {
    name: "RelevanceBar",

    components: {Spinner},

    props: {
        item: {
            required: true,
            type: Object,
        },
    },
}
</script>
