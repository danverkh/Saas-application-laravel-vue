<template>
    <div>
        <slide-up-down v-model="checkoutInit" :duration="slideDuration" timing-function="ease-out">
            <div class="card w-full bg-base-100 shadow-lg rounded-xl border-t-4 border-zinc-300 py-1 mb-6">
                <div class="card-body">
                    <h4 class="-mt-2 font-medium text-xl">Customer details</h4>

                    <div class="divider divider-vertical my-0"></div>

                    <div class="flex flex-col gap-y-3">
                        <div class="flex flex-col gap-y-2">
                            <label for="email" class="whitespace-nowrap font-medium">Your email</label>
                            <Input @keyup.enter="proceed" v-model="email" type="email" id="email" :error="validationErrors?.email" @change="validationErrors.email = null" class="text-zinc-900 text-base"/>
                        </div>
                    </div>
                </div>
            </div>
        </slide-up-down>

        <checkout-button @clicked="proceed">
            <div v-if="!checkoutInit">Confirm keywords <br class="hidden xl:block"> and proceed</div>
            <div v-else class="text-xl tracking-widest text-center pl-5">Submit</div>
        </checkout-button>
    </div>
</template>

<script>
import {mapWritableState} from 'pinia';
import CheckoutButton from './Checkout/CheckoutButton.vue';
import Input from '@/components/Input.vue';
import {useCart} from '@/stores/cart';

export default {
    name: 'Checkout',

    components: {CheckoutButton, Input},

    computed: {
        ...mapWritableState(useCart, ['email', 'validationErrors']),
    },

    data() {
        return {
            checkoutInit: false,
            slideDuration: 300,
        };
    },

    mounted() {
        useCart().validationErrors = [];
    },

    methods: {
        proceed() {
            if (!this.checkoutInit) {
                // Step 1
                this.checkoutInit = true;
                setTimeout(() => document.querySelector('input[type=email]').focus(), this.slideDuration);
            } else {
                // Step 2
                useCart()
                    .validate()
                    .then(() => window.location.href = route('checkout.payment'));
            }
        },
    },
}
</script>
