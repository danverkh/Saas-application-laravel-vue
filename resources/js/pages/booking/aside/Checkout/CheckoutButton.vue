<template>
    <div @click="click"
         tabindex="2"
         :class="[hasSelections ? '' : 'opacity-75']"
         class="group flex flex-nowrap items-center mt-6 md:mt-0 pl-3 pr-5 py-8 lg:py-5 xl:py-5 text-lg md:text-base xl:text-md font-semibold text-white tracking-wider uppercase
                select-none transition duration-500 ease-in-out transform bg-green-600 rounded-2xl shadow-lg shadow-zinc-300 border border-green-700/50
                hover:shadow-green-500/50 overflow-hidden cursor-pointer focus:outline-green-700">

        <div class="flex-1 xl:text-right">
            <slot></slot>
        </div>

        <span class="divider divider-horizontal ml-3 mr-1"></span>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 transition-transform group-hover:translate-x-0.5">
            <path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/>
        </svg>
    </div>

    <div v-if="error" class="text-red-600 text-sm text-center mt-2">Please select at least one keyword</div>
</template>

<script>
import {useCart} from "@/stores/cart";

export default {
    name: "CheckoutButton",

    emits: ['clicked'],

    data() {
        return {
            error: false,
        };
    },

    computed: {
        hasSelections() {
            return useCart().selectedItems.length > 0;
        },
    },

    watch: {
        hasSelections(value) {
            if (value) {
                this.error = false;
            }
        },
    },

    methods: {
        click() {
            if (this.hasSelections) {
                this.$emit('clicked');
            } else {
                this.error = true;
            }
        },
    },
}
</script>
