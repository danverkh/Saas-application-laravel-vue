<template>
    <div class="text-lg inline-block">
        Domain: <span class="font-semibold">{{ query }}</span>
        <button class="inline-block text-sm ml-2 text-primary hover:underline">(change)</button>
    </div>
</template>

<script>
export default {
    name: "DomainSwitcher",

    props: {
        query: String,
    },

    computed: {
        idDomain() {

        },
    },
}
</script>
