<template>
    <div class="text-lg inline-block">
        {{ isDomain ? 'Domain' : 'Keyword' }}: <span class="font-semibold">{{ query }}</span>
        <button class="inline-block text-sm -mt-1 ml-2 text-primary hover:underline">(change)</button>
    </div>
</template>

<script>
export default {
    name: "DomainSwitcher",

    props: {
        market: String,
        query: String,
        isDomain: Boolean,
    },
}
</script>
