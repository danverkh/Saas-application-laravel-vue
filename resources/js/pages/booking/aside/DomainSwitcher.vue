<template>
    <div class="inline-block">
        <div class="text-base mb-1">Domain:</div>
        <div>
            <span class="text-xl font-semibold break-all">{{ domain }}</span>
            <label for="domain-switcher-modal" class="cursor-pointer text-sm -mt-1 ml-2 text-primary hover:underline relative bottom-0.5">(change)</label>
        </div>
    </div>
</template>

<script>
export default {
    name: "DomainSwitcher",

    props: {
        market: String,
        domain: String,
    },
}
</script>
