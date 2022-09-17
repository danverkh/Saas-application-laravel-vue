<template>
    <div class="card w-full bg-base-100 shadow-lg rounded-xl border-t-4 border-zinc-300 py-1">
        <div class="card-body">
            <h4 class="-mt-2 font-medium text-xl">Customer details</h4>

            <div class="divider divider-vertical my-0"></div>

            <div class="flex flex-col gap-y-3">
                <div class="flex flex-col gap-y-2">
                    <label for="name" class="whitespace-nowrap font-medium">Your name</label>
                    <Input v-model="customer_name" id="name" :error="validationErrors?.customer_name"/>
                </div>

                <div class="flex flex-col gap-y-2">
                    <label for="email" class="whitespace-nowrap font-medium">Your email</label>
                    <Input v-model="customer_email" type="email" id="email" :error="validationErrors?.customer_email"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState, mapWritableState} from "pinia";
import {useCart} from "@/stores/cart";
import Input from "@/components/Input.vue";

export default {
    name: "CustomerDetails",

    components: {Input},

    computed: {
        ...mapWritableState(useCart, ['customer_name', 'customer_email']),
        ...mapState(useCart, ['validationErrors']),
    },
}
</script>
