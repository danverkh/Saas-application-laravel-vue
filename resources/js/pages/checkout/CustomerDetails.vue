<template>
    <div class="flex flex-col max-w-xl gap-y-5 text-lg mt-3">
        <div class="flex flex-row gap-x-10">
            <label for="name" class="whitespace-nowrap font-medium text-zinc-400 mt-2">Your name</label>
            <Input v-model="customer_name" id="name" :error="validationErrors?.customer_name"/>
        </div>

        <div class="flex flex-row gap-x-10">
            <label for="email" class="whitespace-nowrap font-medium text-zinc-400 mt-2">Your email</label>
            <Input v-model="customer_email" type="email" id="email" :error="validationErrors?.customer_email"/>
        </div>
    </div>
</template>

<script>
import {useCart} from "../../stores/cart";
import {mapWritableState} from "pinia/dist/pinia";
import {mapState} from "pinia";
import Input from "../../components/Input.vue";

export default {
    name: "CustomerDetails",

    components: {Input},

    computed: {
        ...mapWritableState(useCart, ['customer_name', 'customer_email']),
        ...mapState(useCart, ['validationErrors']),
    },
}
</script>
