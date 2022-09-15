<template>
    <div class="fixed z-90 w-0 h-0 flex justify-center items-center bg-gray-900 opacity-0 duration-700">
        <span class="loader" :style="{width: `${size}px`, height: `${size}px`, 'border-width': `${borderWidth}px`, 'border-color': color}"></span>
    </div>
</template>

<script>
export default {
    name: "Spinner",

    props: {
        size: {
            type: Number,
            default: 50,
        },
        borderWidth: {
            type: Number,
            default: 6,
        },
        color: {
            type: String,
            default: '#dd2b47',
        },
    },

    mounted() {

    },
}
</script>

<style scoped>
.loader {
    border-style: solid;
    border-bottom-color: transparent !important;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
