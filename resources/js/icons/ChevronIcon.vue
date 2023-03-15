<template>
    <svg v-if="sort === null" xmlns="http://www.w3.org/2000/svg" viewBox="10 0 12 32" :class="['fill-current', classes]">
        <path fill="currentColor" d="m16 28l-7-7l1.41-1.41L16 25.17l5.59-5.58L23 21l-7 7zm0-24l7 7l-1.41 1.41L16 6.83l-5.59 5.58L9 11l7-7z"/>
    </svg>
    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="10 0 12 32" :class="['fill-current', classes, {'transform rotate-180': sort === 'desc'}]">
        <path fill="currentColor" d="m16 4l7 7l-1.4 1.4L16 6.8l-5.6 5.6L9 11z"/>
    </svg>
</template>

<script>
export default {
    name: "ChevronIcon",

    props: {
        sort: {
            type: String,
            default: null,
        },

        classes: {
            type: String,
            default: 'w-5 h-5',
        },
    },
}
</script>
