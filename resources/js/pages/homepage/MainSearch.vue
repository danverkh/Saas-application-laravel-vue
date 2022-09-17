<template>
    <market-select @changed="market = $event" :selected="market" class="grow-0"></market-select>

    <div class="flex-1">
        <label class="block text-gray-500 mb-2">Domain</label>
        <input v-model="domain"
               @keyup.enter="search"
               type="text"
               placeholder="Please enter a domain here..."
               :class="{'border-primary': invalid}"
               class="main-search input input-lg h-[60px] w-full ring-1 ring-gray-300 px-4 md:px-8 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none"/>
    </div>

    <div class="grow-0">
        <button @click="search" class="btn btn-lg no-animation gap-2 tracking-widest bg-gray-900 h-[62px] min-h-[62px] md:px-7">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 md:-ml-1">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd"/>
            </svg>
            <span class="md:ml-1 hidden md:inline">Search</span>
        </button>
    </div>
</template>

<script>
import MarketSelect from './MarketSelect.vue';
import {useCart} from "../../stores/cart";

export default {
    name: "MainSearch",

    components: {MarketSelect},

    data() {
        return {
            market: useCart().market || 'at',
            domain: '',
            invalid: false,
        };
    },

    watch: {
        domain(value) {
            if (value.length > 0) {
                this.invalid = false;
            }
        },
    },

    methods: {
        search() {
            if (this.domain.length === 0) {
                this.invalid = true;
            } else {
                const domain = encodeURIComponent(this.domain);

                useCart().market = this.market;

                window.location.href = `/${this.market}/${domain}`;
            }
        },
    },
}
</script>
