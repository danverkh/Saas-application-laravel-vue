<template>
    <div @click="submit"
         :class="[valid ? 'cursor-pointer' : 'opacity-75']"
         class="mx-auto flex flex-nowrap items-center w-full md:w-[240px] my-10 pl-4 pr-6 py-5 lg:py-6 text-lg md:text-base xl:text-xl font-semibold text-white tracking-wider uppercase
            select-none transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50 hover:shadow-green-500/50">

        <svg width="24" height="24" viewBox="0 0 576 512" class="w-6 h-6 ml-3 hidden md:inline">
            <path fill="currentColor" d="M576 216v16c0 13.255-10.745 24-24 24h-8l-26.113 182.788C514.509 462.435 494.257 480 470.37 480H105.63c-23.887 0-44.139-17.565-47.518-41.212L32 256h-8c-13.255 0-24-10.745-24-24v-16c0-13.255 10.745-24 24-24h67.341l106.78-146.821c10.395-14.292 30.407-17.453 44.701-7.058c14.293 10.395 17.453 30.408 7.058 44.701L170.477 192h235.046L326.12 82.821c-10.395-14.292-7.234-34.306 7.059-44.701c14.291-10.395 34.306-7.235 44.701 7.058L484.659 192H552c13.255 0 24 10.745 24 24zM312 392V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm112 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm-224 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24z"/>
        </svg>

        <span class="divider divider-horizontal mx-4 hidden md:flex"></span>

        <div class="flex-1 text-center tracking-widest md:tracking-wide">Submit</div>
    </div>
</template>

<script>
import {useCart} from "../../stores/cart";
import {mapState} from "pinia";

export default {
    name: "SubmitOrderButton",

    computed: {
        ...mapState(useCart, ['valid']),
    },

    methods: {
        submit() {
            useCart().createOrder();
        },
    },
}
</script>
