<template>
    <div class="text-lg inline-block">
        Domain: <span class="font-semibold">{{ domain }}</span>
        <label for="domain-switcher-modal" class="cursor-pointer text-sm -mt-1 ml-2 text-primary hover:underline relative bottom-0.5">(change)</label>
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
