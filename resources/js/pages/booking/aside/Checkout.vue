<template>
    <div>
        <slide-up-down v-model="checkoutInit" :duration="slideDuration" timing-function="ease-out">
            <div class="card w-full bg-base-100 shadow-lg rounded-xl border-t-4 border-zinc-300 py-1 mb-6">
                <div class="card-body">
                    <div @click="close" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-50 hover:text-primary hover:bg-primary-50/50">✕</div>

                    <h4 class="-mt-2 font-medium text-lg">Customer details</h4>
                    <div class="divider divider-vertical my-0"></div>

                    <div class="flex flex-col gap-y-3 mb-6">
                        <div class="flex flex-col gap-y-2">
                            <label for="customer-email" class="whitespace-nowrap font-medium">Your email</label>
                            <Input @keyup.enter="open"
                                   v-model="email"
                                   type="email"
                                   id="customer-email"
                                   tabindex="1"
                                   :error="validationErrors?.email"
                                   @change="validationErrors.email = null"
                                   error-classes="text-xs"
                                   class="text-zinc-900 text-base"/>
                        </div>
                    </div>

                    <h4 class="-mt-2 font-medium text-lg">Payment</h4>
                    <div class="divider divider-vertical my-0"></div>

                    <div class="bg-zinc-100 h-32 grid place-content-center text-zinc-400">
                        placeholder
                    </div>
                </div>
            </div>
        </slide-up-down>

        <checkout-button @clicked="open">
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

        if(this.$auth.check) {
            this.email = this.$auth.user.email;
        }
    },

    methods: {
        open() {
            if (!this.checkoutInit) {
                // Step 1
                this.checkoutInit = true;
                setTimeout(() => document.querySelector('#customer-email').focus(), this.slideDuration);
            } else {
                // Step 2
                useCart()
                    .createOrder()
                    .then(() => window.location.href = route('checkout.thank_you'));
            }
        },

        close() {
            this.checkoutInit = false;
        },
    },
}
</script>
