<template>
    <div class="w-full bg-zinc-400 h-4 rounded-xl overflow-hidden min-w-[50px] relative">
        <div class="bg-[#cfbe00] h-full transition-all duration-1000 ease-out absolute top-0 left-0" :style="{right: `${100 - item.relevance}%`}"></div>
        <div class="text-xs text-white px-2.5 font-medium relative text-left">{{ item.relevance ? item.relevance + '%' : '' }}</div>
    </div>
</template>

<script>
export default {
    name: "RelevanceBar",

    props: {
        item: {
            required: true,
            type: Object,
        },
    },
}
</script>
