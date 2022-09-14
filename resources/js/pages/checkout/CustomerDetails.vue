<template>
    <div class="flex flex-col max-w-xl gap-y-5 text-lg mt-3">
        <div class="flex flex-row gap-x-10">
            <label for="name" class="whitespace-nowrap font-medium text-zinc-400 mt-2">Your name</label>
            <input type="text" v-model="name" id="name" class="input w-full text-lg ring-1 ring-gray-300 px-4 py-1 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none">
        </div>
        <div class="flex flex-row gap-x-10">
            <label for="email" class="whitespace-nowrap font-medium text-zinc-400 mt-2">Your email</label>
            <input type="text" v-model="email" id="email" class="input w-full text-lg ring-1 ring-gray-300 px-4 py-1 hover:ring-2 hover:ring-primary/50 focus:ring-2 focus:ring-primary/50 focus:outline-none">
        </div>
    </div>
</template>

<script>
import {useCart} from "../../stores/cart";
import {mapWritableState} from "pinia/dist/pinia";

export default {
    name: "CustomerDetails",

    computed: {
        ...mapWritableState(useCart, ['name', 'email']),
    },
}
</script>
