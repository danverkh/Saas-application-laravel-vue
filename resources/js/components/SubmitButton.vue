<template>
    <div :class="[disabled ? 'pointer-events-none opacity-50' : 'cursor-pointer', colorClasses]"
         class="group flex flex-nowrap items-center justify-center pl-3 pr-5 py-5 text-lg md:text-base xl:text-md font-semibold text-white tracking-wider uppercase
                select-none transition duration-500 ease-in-out transform rounded-2xl shadow-lg shadow-zinc-300 border overflow-hidden">

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
        color: {
            default: 'green',
            type: String,
        },
    },

    computed: {
        colorClasses() {
            switch(this.color) {
                case 'green': return 'bg-green-600 border-green-700/50 hover:shadow-green-500/50';
                case 'secondary': return 'bg-secondary border-secondary/50 hover:shadow-secondary/50';
                case 'primary': return 'bg-primary border-primary/50 hover:shadow-primary/50';
            }
        },
    },
}
</script>
