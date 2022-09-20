<template>
    <div :class="[disabled ? 'pointer-events-none opacity-75' : 'cursor-pointer']"
         class="group flex flex-nowrap items-center justify-center pl-3 pr-5 py-8 lg:py-5 xl:py-5 text-lg md:text-base xl:text-md font-semibold text-white tracking-wider uppercase
                select-none transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50 hover:shadow-green-500/50
                overflow-hidden">

        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "SubmitButton",

    props: {
        disabled: {
            type: Boolean,
            default: false,
        },
    },
}
</script>
